<?php

namespace app\controllers;

use Yii;
use app\models\RecieveMoney;
use app\models\RecieveMoneySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecieveMoneyController implements the CRUD actions for RecieveMoney model.
 */
class RecieveMoneyController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (empty(\Yii::$app->session['user'])) {
            if (Yii::$app->controller->action->id != "login") {
                $this->redirect(['site/login']);
            }
        } elseif (Yii::$app->session['timeout'] < date('dHi')) {
            unset(\Yii::$app->session['user']);
            $this->redirect(['site/login']);
        } else {
            Yii::$app->session['timeout'] = Yii::$app->params['timeout'];
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all RecieveMoney models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecieveMoneySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RecieveMoney model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RecieveMoney model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RecieveMoney();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ລາຍ​ຮັບຖືກ​ເກັບ​ໄວ້​ໃນ​ລະ​ບົບ​ແລ້ວ.....'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RecieveMoney model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ທ່ານ​ສຳ​ເລັດ​ການ​ແກ້​ໄຂ​ແລ້ວລາຍ​ຮັບ​ນີ້​ແລ້ວ......'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', 'ແກ້​ໄຂ'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RecieveMoney model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RecieveMoney model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecieveMoney the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecieveMoney::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReport()
    {

        if (Yii::$app->session['user']->user_type == "Admin") {
            $model = RecieveMoney::find()->joinWith('user')->where(['user.user_role_id' => \Yii::$app->session['user']->user_role_id])->andWhere(['between', 'recieve_money.date', date("Y-m-d", strtotime('monday this week')), date("Y-m-d", strtotime('sunday this week'))])->orderBy('recieve_money.date DESC')->all();
            $model_m = RecieveMoney::find()->joinWith('user')->where(['user.user_role_id' => \Yii::$app->session['user']->user_role_id])->andWhere(['month(recieve_money.date)' => date('m')])->orderBy('recieve_money.date DESC')->all();
            $model_y = RecieveMoney::find()->joinWith('user')->where(['user.user_role_id' => \Yii::$app->session['user']->user_role_id])->andWhere(['year(recieve_money.date)' => date('Y')])->orderBy('recieve_money.date DESC')->all();
        } else {
            $model = RecieveMoney::find()->where(['user_id' => \Yii::$app->session['user']->id])->andWhere(['between', 'date', date("Y-m-d", strtotime('monday this week')), date("Y-m-d", strtotime('sunday this week'))])->orderBy('date DESC')->all();
            $model_m = RecieveMoney::find()->where(['user_id' => \Yii::$app->session['user']->id])->andWhere(['month(date)' => date('m')])->orderBy('date DESC')->all();
            $model_y = RecieveMoney::find()->where(['user_id' => \Yii::$app->session['user']->id])->andWhere(['year(date)' => date('Y')])->orderBy('date DESC')->all();
        }
        return $this->render('report', ['model' => $model, 'model_m' => $model_m, 'model_y' => $model_y]);
    }

}
