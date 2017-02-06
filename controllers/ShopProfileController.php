<?php

namespace app\controllers;

use Yii;
use app\models\ShopProfile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * ShopProfileController implements the CRUD actions for ShopProfile model.
 */
class ShopProfileController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all ShopProfile models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => ShopProfile::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShopProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ShopProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ShopProfile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        ini_set('memory_limit', '2048M');
        $model = $this->findModel($id);
        $photo_old = $model->logo;
        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'logo');
            if (!empty($photo)) {
                $photo_name = date('YmdHmsi') . '.' . $photo->extension;
                $photo->saveAs(Yii::$app->basePath . '/web/images/' . $photo_name);
                Image::thumbnail(Yii::$app->basePath . '/web/images/' . $photo_name, 150, 150)
                        ->resize(new Box(150, 150))
                        ->save(Yii::$app->basePath . '/web/images/thume/' . $photo_name, ['quality' => 70]);
                unlink(Yii::$app->basePath . '/web/images/' . $photo_name);
                $model->logo = $photo_name;
            } else {
                $model->logo = $photo_old;
            }
            $model->save();
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ທ່ານ​ໄດ້​ແກ້​ໄຂ​ຂໍ້​ມູນແລ້ວ.......'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ShopProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ShopProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
