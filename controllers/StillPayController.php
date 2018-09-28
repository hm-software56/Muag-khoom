<?php

namespace app\controllers;

use Yii;
use app\models\StillPay;
use app\models\StillPaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Custommer;

/**
 * StillPayController implements the CRUD actions for StillPay model.
 */
class StillPayController extends Controller
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

    /**
     * Lists all StillPay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StillPaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StillPay model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StillPay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StillPay();
        $model->date=date('Y-m-d H:i:s');
        $model->status='1';
        if ($model->load(Yii::$app->request->post())) {
            if(empty($model->name))
            {
                $model->name="1";
            }
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreatecus()
    {
        if(isset($_POST['name']))
        {
            $cus=new Custommer();
            $cus->status='1';
            $cus->name=$_POST['name'];
            if($cus->save())
            {
                return $this->redirect(['create']);
            }
            print_r($cus->getErrors());
        }
    }
    public function actionPaid($id)
    {
        $model = $this->findModel($id);
        $model->date = date('Y-m-d H:i:s');
        $model->status = '0';
        if ($model->save()) {
            return $this->redirect(['index']);
        }
    }
    /**
     * Updates an existing StillPay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StillPay model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

       // return "sss";
    }

    /**
     * Finds the StillPay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StillPay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StillPay::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
