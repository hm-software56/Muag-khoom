<?php

namespace app\controllers;

use Yii;
use app\models\Products;
use app\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller {

    public function beforeAction($action) {
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = "main_2";
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['defaultPageSize' => 50000];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSale() {
        $this->layout = "main_pos";
        $model = Products::find()->orderBy('code ASC')->all();
        return $this->render('sale', [
                    'model' => $model,
        ]);
    }

    public function actionOrder($id) {
        if (!empty(\Yii::$app->session['product'])) {
            $array = [];
            $already_pr_id = false;
            foreach (\Yii::$app->session['product'] as $order_p) {
                if ($order_p['id'] == $id) {
                    $already_pr_id = true;
                    $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity'] + 1];
                } else {
                    $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity']];
                }
            }
            if ($already_pr_id == false) {
                $array[] = ['id' => $id, 'qautity' => 1];
            }
            Yii::$app->session['product'] = $array;
        } else {
            \Yii::$app->session['product'] = [['id' => $id, 'qautity' => 1]];
        }
        return $this->renderAjax('order', [
        ]);
    }

    public function actionOrdercancle() {
        unset(Yii::$app->session['product']);
        return $this->renderAjax('order');
    }

    public function actionOrderdelete($id) {
        if (!empty(\Yii::$app->session['product'])) {
            $array = [];
            foreach (\Yii::$app->session['product'] as $order_p) {
                if ($order_p['id'] != $id) {
                    $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity']];
                }
            }
            Yii::$app->session['product'] = $array;
        }
        return $this->renderAjax('order');
    }

    public function actionChageqautity($id) {
        if (!empty(\Yii::$app->session['product'])) {
            $array = [];
            foreach (\Yii::$app->session['product'] as $order_p) {
                if ($order_p['id'] == $id) {
                    $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity'] - 1];
                } else {
                    $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity']];
                }
            }
            Yii::$app->session['product'] = $array;
        }
        return $this->renderAjax('order', [
        ]);
    }

    public function actionPay() {
        if (isset($_GET['totalprice'])) {
            \Yii::$app->session['totalprice'] = $_GET['totalprice'];
            unset(\Yii::$app->session['payprice']);
            unset(\Yii::$app->session['paystill']);
            unset(\Yii::$app->session['paychange']);
        }

        if (isset($_GET['pricetxt'])) {
            \Yii::$app->session['payprice'] = $_GET['pricetxt'];
            if (\Yii::$app->session['totalprice'] - $_GET['pricetxt'] > 0) {
                \Yii::$app->session['paystill'] = \Yii::$app->session['totalprice'] - $_GET['pricetxt'];
            } else {
                \Yii::$app->session['paystill'] = 0;
            }
            if (($_GET['pricetxt'] - \Yii::$app->session['totalprice']) > 0) {
                \Yii::$app->session['paychange'] = $_GET['pricetxt'] - \Yii::$app->session['totalprice'];
            } else {
                \Yii::$app->session['paychange'] = 0;
            }
        }
        return $this->renderAjax('pay');
    }

    public function actionOrdercomfirm() {
        return $this->renderAjax('comfirm');
    }

    public function actionSearch($searchtxt) {
        $model = Products::find()->where(['code' => $searchtxt])->one();
        if (!empty($model)) {
            if (!empty(\Yii::$app->session['product'])) {
                $array = [];
                $already_pr_id = false;
                foreach (\Yii::$app->session['product'] as $order_p) {
                    if ($order_p['id'] == $model->id) {
                        $already_pr_id = true;
                        $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity'] + 1];
                    } else {
                        $array[] = ['id' => $order_p['id'], 'qautity' => $order_p['qautity']];
                    }
                }
                if ($already_pr_id == false) {
                    $array[] = ['id' => $model->id, 'qautity' => 1];
                }
                Yii::$app->session['product'] = $array;
            } else {
                \Yii::$app->session['product'] = [['id' => $model->id, 'qautity' => 1]];
            }
        }
        return $this->renderAjax('order', [
        ]);
    }

    public function actionCancle($id) {

        // $model = new \app\models\Sale;
        $product = Products::find()->where(['id' => $id])->one();

        if (isset($_POST['qtt'])) {
            for ($i = 1; $i <= $_POST['qtt']; $i++) {
                $model = \app\models\Sale::find()->where(['products_id' => $id])->orderBy('id DESC')->one();
                $model->delete();
            }
            $qtt = $product->qautity + $_POST['qtt'];
            Products::updateAll(['qautity' => $qtt], ['id' => $id]);
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ຢັ້ງ​ຢືນ​ການ​ລືບ​ອອກສຳ​ເລັດ​ແລ້ວ..........'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            $this->redirect(['products/repaortsale']);
        }
        return $this->renderAjax('cancle', [
                    'product' => $product
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->layout = "main_2";
        $model = new Products();

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $photo_name = date('YmdHmsi') . '.' . $model->image->extension;
            $model->image->saveAs(Yii::$app->basePath . '/web/images/' . $photo_name);
            Image::thumbnail(Yii::$app->basePath . '/web/images/' . $photo_name, 250, 250)
                    ->resize(new Box(250, 250))
                    ->save(Yii::$app->basePath . '/web/images/thume/' . $photo_name, ['quality' => 70]);
            unlink(Yii::$app->basePath . '/web/images/' . $photo_name);
            $model->image = $photo_name;
            $model->save();
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ລາຍ​ຈ່າຍ​ຖືກ​ເກັບ​ໄວ້​ໃນ​ລະ​ບົບ​ແລ້ວ'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $this->layout = "main_2";
        $model = $this->findModel($id);
        $photo_old = $model->image;

        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'image');
            if (!empty($photo)) {
                $photo_name = date('YmdHmsi') . '.' . $photo->extension;
                $photo->saveAs(Yii::$app->basePath . '/web/images/' . $photo_name);
                Image::thumbnail(Yii::$app->basePath . '/web/images/' . $photo_name, 150, 150)
                        ->resize(new Box(150, 150))
                        ->save(Yii::$app->basePath . '/web/images/thume/' . $photo_name, ['quality' => 70]);
                unlink(Yii::$app->basePath . '/web/images/' . $photo_name);
                $model->image = $photo_name;
            } else {
                $model->image = $photo_old;
            }
            $model->save();
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ທ່ານ​ສຳ​ເລັດ​ການ​ແກ້​ໄຂ​ແລ້ວ'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', 'ແກ້​ໄຂ'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRepaortsale() {
        $this->layout = "main_2";
        if (isset($_POST['date_sale']) && !empty($_POST['date_sale'])) {
            $model = \app\models\Sale::find()->where(['date' => $_POST['date_sale']])->orderBy('products_id ASC')->all();
        } else {
            $model = \app\models\Sale::find()->orderBy('products_id ASC')->all();
        }
        return $this->render('reportsale', ['model' => $model]);
    }

    public function actionProduct() {
        $this->layout = "main_2";
        $model = Products::find()->orderBy('code ASC')->all();
        return $this->render('product', ['model' => $model]);
    }

    public function actionRepsaleornot() {
        $this->layout = "main_2";
        $model = Products::find()->orderBy('code ASC')->all();
        return $this->render('repsaleornot', ['model' => $model]);
    }

}
