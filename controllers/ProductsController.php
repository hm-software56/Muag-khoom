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
use yii\helpers\Html;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller {

    public function beforeAction($action) {
        if (empty(\Yii::$app->session['user'])) {
            if (Yii::$app->controller->action->id != "login") {
                $this->redirect(['site/login']);
                return false;
            }
        } elseif (Yii::$app->session['timeout'] < date('dHi')) {
            unset(\Yii::$app->session['user']);
            $this->redirect(['site/login']);
            return false;
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

        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['defaultPageSize' => 20];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSale() {
        $this->layout = "main_pos";
        if (!empty(Yii::$app->session['cormfirm'])) {  /// after done payment clear old order then older new
            unset(Yii::$app->session['product']);
            unset(\Yii::$app->session['cormfirm']);
            unset(\Yii::$app->session['notinbarcode']);
            unset(\Yii::$app->session['discount']);
        }

        if (isset($_GET['cid'])) {
            if (!empty($_GET['cid'])) {
                $model = Products::find()->where(['category_id' => $_GET['cid']])->orderBy('id ASC')->all();
            } else {
                $model = Products::find()->orderBy('id ASC')->all();
            }
            return $this->renderAjax('pos_pro', [
                        'model' => $model,
            ]);
        } else {
            $model = Products::find()->orderBy('id ASC')->all();
            return $this->render('sale', [
                        'model' => $model,
            ]);
        }
    }

    public function actionOrder($id) {
        if (!empty(Yii::$app->session['cormfirm'])) { /// after done payment clear old order then older new
            unset(Yii::$app->session['product']);
            unset(\Yii::$app->session['cormfirm']);
            unset(\Yii::$app->session['notinbarcode']);
            unset(\Yii::$app->session['discount']);
            unset(Yii::$app->session['product_id']);
        }

        $model = Products::find()->where('id='.$id.' and qautity>0')->one();
        if (!empty($model)) {
            if (!empty(\Yii::$app->session['product'])) {
                $array = [];
                if(!in_array($id, \Yii::$app->session['product_id']))
                {
                    $array[$model->id]=1;
                    \Yii::$app->session['product_id']=array_merge(array($model->id),\Yii::$app->session['product_id']);
                    \Yii::$app->getSession()->setFlash('su',$model->id);
                    \Yii::$app->getSession()->setFlash('success','ເພີ່ມ​ສີ​ນ​ຄ້າ​ແລ້ວ.......');
                        
                }
                foreach (\Yii::$app->session['product'] as $order_p=>$qautity) {
                    if($order_p==$model->id)
                    {
                        if($qautity>=$model->qautity)
                        {
                            $array[$order_p]=$qautity;
                            \Yii::$app->getSession()->setFlash('error', $order_p);
                            \Yii::$app->getSession()->setFlash('errors', 'ຈຳ​ນວນ​ສີນ​ຄ້າ​ໝົດ.......');
                        }else{
                            $array[$order_p]=$qautity+1;
                            \Yii::$app->getSession()->setFlash('su',$order_p);
                            \Yii::$app->getSession()->setFlash('success','ເພີ່ມ​ສີ​ນ​ຄ້າ​ແລ້ວ.......');
                        }
                    }else{
                        $array[$order_p]=$qautity;
                    }    
                } 
                Yii::$app->session['product'] =$array;
            } else {
                \Yii::$app->session['product'] = [$model->id =>1];
                \Yii::$app->session['product_id'] = [$model->id];
            }
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        } else {
            \Yii::$app->getSession()->setFlash('errors', \Yii::t('app', 'ຈ​ຳ​ນວນ​ສີນ​ຄ້າ​ໝົດ...'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        }
        return $this->renderAjax('order', [
        ]);
    }

    public function actionOrdercancle() {
        unset(Yii::$app->session['product']);
        unset(Yii::$app->session['product_id']);
        unset(\Yii::$app->session['cormfirm']);
        unset(\Yii::$app->session['notinbarcode']);
        unset(\Yii::$app->session['discount']);
        return $this->renderAjax('order');
    }

    public function actionOrderdelete($id) {

        if (!empty(\Yii::$app->session['product'])) {
            $array = [];
            $product_id = [];
            foreach (\Yii::$app->session['product'] as $order_p=>$qautity) {
                    if($order_p!=$id)
                    {
                        $array[$order_p]=$qautity;
                        $product_id[]=$order_p;
                    }    
            } 
            \Yii::$app->session['product_id'] = $product_id;
            Yii::$app->session['product'] = $array;
        }
        return $this->renderAjax('order');
    }

    public function actionChageqautity($id = NULL, $qautity_new = NULL) {

        if (!empty($id)&& !empty($qautity_new)) {
            if (!empty(\Yii::$app->session['product'])) {
                $array = [];
                $product_id=[];
                foreach (\Yii::$app->session['product'] as $order_p=>$qautity) {
                    if ($order_p == $id) {
                        $model = Products::find()->where('id='.$order_p.' and qautity>='.$qautity_new.'')->one();
                        if(!empty($model))
                        {
                            $array[$order_p]=$qautity_new;
                            \Yii::$app->getSession()->setFlash('su',$order_p);
                            \Yii::$app->getSession()->setFlash('success','ເພີ່ມ​ສີ​ນ​ຄ້າ​ແລ້ວ.......');
                        }else{
                            $array[$order_p]=$qautity;
                            \Yii::$app->getSession()->setFlash('error',$order_p);
                            \Yii::$app->getSession()->setFlash('errors', 'ຈຳ​ນວນ​ສີນ​ຄ້າ​ບໍ່​ພໍ.......');
                        }
                        $product_id[]=$order_p;
                    } else {
                        $array[$order_p]=$qautity;
                        $product_id[]=$order_p;
                    }
                }
                \Yii::$app->session['product'] = $array;
                \Yii::$app->session['product_id'] = $product_id;
            }
            return $this->renderAjax('order', [
            ]);
        } else {
            return $this->renderAjax('changeqautity', ['product_id'=>$id,'qautity_old'=>$_GET['qautity_old']]);
        }
    }

    public function actionPay() {
        if (isset($_GET['totalprice'])) {
            \Yii::$app->session['totalprice'] = $_GET['totalprice'] - \Yii::$app->session['discount'];
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
        \Yii::$app->session['cormfirm'] = true;
        $total_prince = 0;
        $pro_id = [];
        if (!empty(\Yii::$app->session['product'])) {
            $invioce = new \app\models\Invoice();
            $lastinvoice = \app\models\Invoice::find()->orderBy('id DESC')->one();
            if (!empty($lastinvoice)) {
                $invioce->code = sprintf('%08d', $lastinvoice->code + 1);
            } else {
                $invioce->code = sprintf('%08d', 1);
            }
            $invioce->date = date('Y-m-d');
            $invioce->user_id = Yii::$app->session['user']->id;
            $invioce->save();

            if (\Yii::$app->session['discount'] != 0) {
                $discount = new \app\models\Discount();
                $discount->discount = \Yii::$app->session['discount'];
                $discount->invoice_id = $invioce->id;
                $discount->save();
            }
            foreach (\Yii::$app->session['product'] as $order_p=>$qautity) {
                if (!in_array($order_p, $pro_id)) {
                    $product = \app\models\Products::find()->where(['id' =>$order_p])->one();
                    $pro_id[] = $order_p;
                    $sale = new \app\models\Sale();
                    $sale->user_id = \Yii::$app->session['user']->id;
                    $sale->products_id = $order_p;
                    $sale->qautity =$qautity;
                    $sale->date = date('Y-m-d');
                    $sale->price = $product->pricesale * $qautity;
                    $sale->invoice_id = $invioce->id;
                    $sale->save();
                    $product->qautity = $product->qautity - $qautity;
                    $product->pricesale = number_format($product->pricesale, 2);
                    $product->pricebuy = number_format($product->pricebuy, 2);
                    $product->save();
                }
            }
        }
        return $this->renderAjax('comfirm', ['invoice' => $invioce]);
    }

    public function actionSearch($searchtxt) {
        $model = Products::find()->joinWith('barcodes', true)->where('products.qautity>0 and barcode.barcode="'.$searchtxt.'" and barcode.status=1')->one();
        if (!empty($model)) {
            if (!empty(\Yii::$app->session['product'])) {
                $array = [];
                if(!in_array($model->id, \Yii::$app->session['product_id']))
                {
                    $array[$model->id]=1;
                    \Yii::$app->session['product_id']=array_merge(array($model->id),\Yii::$app->session['product_id']);
                    \Yii::$app->getSession()->setFlash('su',$model->id);
                    \Yii::$app->getSession()->setFlash('success','ເພີ່ມ​ສີ​ນ​ຄ້າ​ແລ້ວ.......');
                }
                foreach (\Yii::$app->session['product'] as $order_p=>$qautity) {
                    if($order_p==$model->id)
                    {
                        if($qautity>$model->qautity)
                        {
                            $array[$order_p]=$qautity;
                            \Yii::$app->getSession()->setFlash('error', $order_p);
                            \Yii::$app->getSession()->setFlash('errors', 'ຈຳ​ນວນ​ສີນ​ຄ້າໝົດ​ແລ້ວ.......');
                        }else{
                            $array[$order_p]=$qautity+1;
                            \Yii::$app->getSession()->setFlash('su',$order_p);
                            \Yii::$app->getSession()->setFlash('success','ເພີ່ມ​ສີ​ນ​ຄ້າ​ແລ້ວ.......');
                        }
                    }else{
                        $array[$order_p]=$qautity;
                    }    
                } 
                Yii::$app->session['product'] =$array;
            } else {
                \Yii::$app->session['product'] = [$model->id =>1];
                \Yii::$app->session['product_id'] = [$model->id];

                \Yii::$app->getSession()->setFlash('su',$order_p);
                \Yii::$app->getSession()->setFlash('success','ເພີ່ມ​ສີ​ນ​ຄ້າ​ແລ້ວ.......');
            }
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        } else {
            \Yii::$app->getSession()->setFlash('errors', \Yii::t('app', 'ສີນ​ຄ້ານີ້​ບໍ່​ມີ​ໃນ​ລະ​ບົບ ຫຼື່​ ຈຳ​ນວນ​ສີນ​ຄ້າໝົດ​ແລ້ວ...'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        }
        return $this->renderAjax('order', [
        ]);
    }

    public function actionCancle($id, $invoice_id) {

// $model = new \app\models\Sale;
        $product_sale = \app\models\Sale::find()->where(['products_id' => $id, 'invoice_id' => $invoice_id])->one();

        if (isset($_GET['barcode'])) {
            $product_sale->price = $product_sale->price - ($product_sale->price / $product_sale->qautity);
            $product_sale->qautity = $product_sale->qautity - 1;
            if ($product_sale->qautity == 0) {
                $product_sale->delete();
            } else {
                $product_sale->save();
            }
            $qtt = $product_sale->products->qautity + 1;

            Products::updateAll(['qautity' => $qtt], ['id' => $product_sale->products_id]);
            \app\models\Barcode::updateAll(['status' => 1, 'invoice_id' => NULL], ['barcode' => $_GET['barcode']]);

            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ຢັ້ງ​ຢືນ​ການ​ລືບ​ອອກສຳ​ເລັດ​ແລ້ວ..........'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        }
        return $this->renderAjax('cancle', [
                    'product_sale' => $product_sale
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        \Yii::$app->session['pro_id'] = $id;
        $barcode = \app\models\Barcode::find()->where(['products_id' => $id, 'status' => 1])->orderBy('id DESC')->all();
        $model = $this->findModel($id);
        \Yii::$app->session['qt'] = $model->qautity;
        return $this->render('view', [
                    'model' => $model,
                    'barcode' => $barcode
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new Products();

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            $photo_name = date('YmdHmsi') . '.' . $model->image->extension;
            $model->image->saveAs(Yii::$app->basePath . '/web/images/' . $photo_name);
            Image::thumbnail(Yii::$app->basePath . '/web/images/' . $photo_name, 250, 300)
                    ->resize(new Box(250, 300))
                    ->save(Yii::$app->basePath . '/web/images/thume/' . $photo_name, ['quality' => 70]);
            unlink(Yii::$app->basePath . '/web/images/' . $photo_name);
            $model->image = $photo_name;
            $model->user_id = Yii::$app->session['user']->id;
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

        $model = $this->findModel($id);
        $photo_old = $model->image;

        if ($model->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($model, 'image');
            if (!empty($photo)) {
                $photo_name = date('YmdHmsi') . '.' . $photo->extension;
                $photo->saveAs(Yii::$app->basePath . '/web/images/' . $photo_name);
                Image::thumbnail(Yii::$app->basePath . '/web/images/' . $photo_name, 250, 300)
                        ->resize(new Box(250, 300))
                        ->save(Yii::$app->basePath . '/web/images/thume/' . $photo_name, ['quality' => 70]);
                unlink(Yii::$app->basePath . '/web/images/' . $photo_name);
                $model->image = $photo_name;
            } else {
                $model->image = $photo_old;
            }
            $model->user_id = Yii::$app->session['user']->id;
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

    public function actionSetbarcode($barcode, $pro_id) {
        $model_check = \app\models\Barcode::find()->where(['barcode' => $barcode])->one();
        if (empty($model_check)) {
            $newbarcode = new \app\models\Barcode();
            $newbarcode->products_id = $pro_id;
            $newbarcode->barcode = $barcode;
            $newbarcode->save();
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ຖືກ​ເກັບ​ໄວ້​ໃນ​ລະ​ບົບ​ແລ້ວ'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        } else {
            if (!isset($_GET['del'])) {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'ລະ​ຫັດ​ນີ​ຖືກ​ໃຊ້​ກ່ອນ​ແລ້ວ'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            }
        }
        if (isset($_GET['del'])) {
            $model_check->delete();
            \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ຖືກ​ລືບຈາກລະ​ບົບ​ແລ້ວ'));
            \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
        }
        $models = \app\models\Barcode::find()->where(['products_id' => $pro_id, 'status' => 1])->orderBy('id DESC')->all();
        return $this->renderAjax('barcode', ['models' => $models]);
    }

    public function actionQautityupdate($id = NULL, $qautity, $idp = NULL) {
        if (!empty($id)) {
            $product = \app\models\Products::find()->where(['id' => $id])->one();
            $barcode = \app\models\Barcode::find()->where(['products_id' => $id, 'status' => 1])->all();
            // echo count($barcode);
            //echo $qautity;
            // exit;
            if ($qautity > count($barcode)) {
                $product->qautity = $qautity;
                $product->pricesale = number_format($product->pricesale, 2);
                $product->pricebuy = number_format($product->pricebuy, 2);
                $product->save();
                \Yii::$app->getSession()->setFlash('suqtt', \Yii::t('app', 'ແກ້​ໄຂ​ຈຳ​ນວນ​ສີນ​ຄ້າ​ແລ້​ວ'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            } else {
                \Yii::$app->getSession()->setFlash('errorqtt', \Yii::t('app', 'ບໍ່​ສາ​ມາດ​ແກ້​ໄຂ​ຈຳ​ນວນ​ສີ້ນ​ຄ້າ​ໄດ້​....'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            }
            $barcode1 = \app\models\Barcode::find()->where(['products_id' => $id, 'status' => 1])->orderBy('id DESC')->all();
            \Yii::$app->session['qt'] = $product->qautity;
            
           // return $product->qautity;
            return $this->renderAjax('view', [
                        'model' => $product,
                        'barcode' => $barcode1
            ]);
        }

        return $this->renderAjax('qautityupdate', ['qautity' => $qautity, 'id' => $idp]);
    }

    public function actionQautityupdateindex($id = null, $qautity, $idp = null)
    {
        if (!empty($id)) {
            $product = \app\models\Products::find()->where(['id' => $id])->one();
            if ((int)$qautity >0) {
                $product->qautity = (int)$qautity;
                $product->pricesale = number_format($product->pricesale, 2);
                $product->pricebuy = number_format($product->pricebuy, 2);
                $product->user_id = Yii::$app->session['user']->id;
                $product->save();
                \Yii::$app->getSession()->setFlash('su', \Yii::t('app', 'ແກ້​ໄຂ​ຈຳ​ນວນ​ສີນ​ຄ້າ​ແລ້​ວ'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            } else {
                \Yii::$app->getSession()->setFlash('error', \Yii::t('app', 'ບໍ່​ສາ​ມາດ​ແກ້​ໄຂ​ຈຳ​ນວນ​ສີ້ນ​ຄ້າ​ໄດ້​....'));
                \Yii::$app->getSession()->setFlash('action', \Yii::t('app', ''));
            }
            return "<div id=qt" . $product->id . ">" . Html::a($product->qautity, '#', [
                'onclick' => "
                                $.ajax({
                                type:'POST',
                                cache: false,
                                url:'index.php?r=products/qautityupdateindex&idp=" . $product->id . "&qautity=" . $product->qautity . "',
                                success:function(response) {
                                    $('#qt" . $product->id . "').html(response);
                                    document.getElementById('search').focus();
                                }
                                });return false;",
                'class' => "btn btn-sm bg-link",
            ]) . "</div>";
        }

        return $this->renderAjax('qautityupdateindex', ['qautity' => $qautity, 'id' => $idp]);
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
        if (isset($_GET['invoice_code']) || isset($_GET['date'])) {
            if (isset($_GET['invoice_code'])) {
                if (Yii::$app->session['user']->user_type == "POS") {
                    $invoices = \app\models\Invoice::find()->where(['user_id' => Yii::$app->session['user']->id, 'code' => $_GET['invoice_code']])->orderBy('id DESC')->all();
                    if (empty($invoices) && empty($_GET['invoice_code'])) {
                        $invoices = \app\models\Invoice::find()->where(['user_id' => Yii::$app->session['user']->id])->orderBy('id DESC')->all();
                    }
                } else {
                    $invoices = \app\models\Invoice::find()->where(['code' => $_GET['invoice_code']])->orderBy('id DESC')->all();
                    if (empty($invoices) && empty($_GET['invoice_code'])) {
                        $invoices = \app\models\Invoice::find()->orderBy('id DESC')->all();
                    }
                }
            } elseif (isset($_GET['date'])) {
                if (Yii::$app->session['user']->user_type == "POS") {
                    $invoices = \app\models\Invoice::find()->where(['user_id' => Yii::$app->session['user']->id, 'date' => $_GET['date']])->orderBy('id DESC')->all();
                    if (empty($invoices) && empty($_GET['date'])) {
                        $invoices = \app\models\Invoice::find()->where(['user_id' => Yii::$app->session['user']->id])->orderBy('id DESC')->all();
                    }
                } else {
                    $invoices = \app\models\Invoice::find()->where(['date' => $_GET['date']])->orderBy('id DESC')->all();
                    if (empty($invoices) && empty($_GET['date'])) {
                        $invoices = \app\models\Invoice::find()->orderBy('id DESC')->all();
                    }
                }
            }

            return $this->renderAjax('reportsale', ['invoices' => $invoices, 'invoice_code' => @$_GET['invoice_code'], 'date' => @$_GET['date']]);
        } else {
            if (Yii::$app->session['user']->user_type == "POS") {
                $invoices = \app\models\Invoice::find()->where(['user_id' => Yii::$app->session['user']->id])->orderBy('id DESC')->all();
            } else {
                $invoices = \app\models\Invoice::find()->orderBy('id DESC')->all();
            }
            return $this->render('reportsale', ['invoices' => $invoices, 'invoice_code' => "", 'date' => ""]);
        }
    }

    public function actionProduct() {
        $model = Products::find()->where(['not in', 'qautity', [0]])->all();
        return $this->render('product', ['model' => $model]);
    }

    public function actionProductfinish() {
        $model = Products::find()->where(['in', 'qautity', [0]])->all();
        return $this->render('productfinish', ['model' => $model]);
    }

    public function actionRepsaleornot() {

        $model = Products::find()->orderBy('code ASC')->all();
        return $this->render('repsaleornot', ['model' => $model]);
    }

    public function actionGbarcode() {
        return $this->render('gbarcode');
    }

    public function actionSearchpd() {
        if (isset($_GET['searchtxt']) && !empty($_GET['searchtxt'])) {
            $model = Products::find()->where("name like '%" . $_GET['searchtxt'] . "%' ")->all();
        } else {
            $model = Products::find()->orderBy('id ASC')->all();
        }
        return $this->renderAjax('pos_pro', ['model' => $model]);
    }

    public function actionGbcode($id) {
        $product = Products::find()->where(['id' => $id])->one();
        $barcode = \app\models\Barcode::find()->where(['products_id' => $id, 'status' => 1])->all();
        $count = $product->qautity - count($barcode);
        if ($count > 0) {
            for ($i = 1; $i <= $count; $i++) {
                $bcode = new \app\models\Barcode();
                $number = rand(000000000, 999999999);
                $number1 = rand(999, 222);
                $v = $number1 . str_pad($number, 9, '0', STR_PAD_LEFT);
                $bcode->products_id = $id;
                $bcode->status = 1;
                $bcode->barcode = $v;
                $bcode->save();
            }
        }
        return $this->redirect(['products/view', 'id' => $id]);
    }

    public function actionDiscount() {
        if (isset($_GET['dsc'])) {
            \Yii::$app->session['discount'] = $_GET['dsc'];
            return $this->renderAjax('discount', ['discount' => $_GET['dsc']]);
        } else {
            return $this->renderAjax('discount');
        }
    }

    public function actionDashbord()
    {
        return $this->render('dashbord');
    }

}
