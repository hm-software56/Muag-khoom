<?php

namespace app\controllers;

use app\models\ProfileBranch;
use Yii;
use app\models\Branch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BranchController implements the CRUD actions for Branch model.
 */
class BranchController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Branch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Branch::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Branch model.
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
     * Creates a new Branch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Branch();
        $profile_branch = new ProfileBranch();
        if ($model->load(Yii::$app->request->post()) && $profile_branch->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $profile_branch->branch_id = $model->id;
                $profile_branch->save();
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'ສໍາເລັດການເພີ່ມສາຂາ'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'profile_branch' => $profile_branch
        ]);
    }

    /**
     * Updates an existing Branch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $profile_branch = ProfileBranch::find()->where(['branch_id' => $model->id])->one();
        if (!$profile_branch) {
            $profile_branch = new ProfileBranch();
        }
        if ($model->load(Yii::$app->request->post()) && $profile_branch->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $profile_branch->branch_id = $model->id;
                $profile_branch->save();
            }

            Yii::$app->session->setFlash('success', Yii::t('app', 'ສໍາເລັດການແກ້ສາຂາ'));
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'profile_branch' => $profile_branch
        ]);
    }

    /**
     * Deletes an existing Branch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'ສໍາເລັດການລຶບສາຂາ'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'ມີຂໍຜິດພາດການລຶບສາຂາ'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Branch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
