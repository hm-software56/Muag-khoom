<?php

namespace app\controllers;

use app\models\Itemtransfer;
use app\models\Products;
use app\models\Warehousebranch;
use dmstr\db\tests\unit\Product;
use Yii;
use app\models\ProductTransfer;
use app\models\ProductTransferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductTransferController implements the CRUD actions for ProductTransfer model.
 */
class ProductTransferController extends Controller
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
     * Lists all ProductTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        \Yii::$app->session->set('model_items', null);
        $searchModel = new ProductTransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductTransfer model.
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
     * Creates a new ProductTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductTransfer();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->session->get('model_items')) {
            $model->date_create = date('Y-m-d H:i:s');
            $model->date_edit = date('Y-m-d H:i:s');
            $model->tra_user_id = Yii::$app->user->id;
            if ($model->save()) {
                foreach (Yii::$app->session->get('model_items') as $pd) {
                    $items = new Itemtransfer();
                    $items->products_id = $pd->products_id;
                    $items->qautity = $pd->qautity;
                    $items->price_buy = $pd->price_buy;
                    $items->product_transfer_id = $model->id;
                    $items->save();
                }
                Yii::$app->session->set('model_items', null);
                Yii::$app->session->setFlash('success', Yii::t('app', 'ການໂອນສີີນຄ້າໃຫ້ສາຂາສໍາເລັດ.!'));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $products = Products::find()->where(['status' => 1])->all();
        $product_arr = [];
        foreach ($products as $product) {
            $product_arr[$product->id] = $product->name;
        }
        return $this->render('create', [
            'model' => $model,
            'product_arr' => $product_arr
        ]);
    }

    /**
     * Updates an existing ProductTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date_edit = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach (Yii::$app->session->get('model_items') as $pd) {
                $items = Itemtransfer::find()->where(['id' => $pd->id])->one();
                if (empty($items)) {
                    $items = new Itemtransfer();
                }
                $items->products_id = $pd->products_id;
                $items->qautity = $pd->qautity;
                $items->price_buy = $pd->price_buy;
                $items->product_transfer_id = $model->id;

                $items->save();
            }
            Yii::$app->session->set('model_items', null);
            Yii::$app->session->setFlash('success', Yii::t('app', 'ແກ້ໄຂໂອນສີີນຄ້າໃຫ້ສາຂາສໍາເລັດ.!'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $items = Itemtransfer::find()->where(['product_transfer_id' => $model->id])->orderBy('id DESC')->all();
        Yii::$app->session->set('model_items', $items);

        /* ========== list all product========*/
        $products = Products::find()->where(['status' => 1])->all();
        $product_arr = [];
        foreach ($products as $product) {
            $product_arr[$product->id] = $product->name;
        }
        return $this->render('update', [
            'model' => $model,
            'product_arr' => $product_arr
        ]);

    }

    /**
     * Deletes an existing ProductTransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionConfirm($id)
    {
        $model = ProductTransfer::find()->where(['id' => $id])->one();
        if ($model) {
            $model->status = 1;
            $model->date_edit = date('Y-m-d H:i:s');
            if ($model->save()) {
                $items = Itemtransfer::find()->where(['product_transfer_id' => $model->id])->all();
                foreach ($items as $item) {
                    $warehouseB = Warehousebranch::find()->where(['products_id' => $item->products_id, 'branch_id' => $model->branch_id])->one();
                    if (empty($warehouseB)) {
                        $warehouseB = new Warehousebranch();
                    }
                    $warehouseB->qautity = $warehouseB->qautity + $item->qautity;
                    $warehouseB->products_id = $item->products_id;
                    $warehouseB->branch_id = $model->branch_id;
                    if ($warehouseB->save()) {
                        $warehousemain = Products::find()->where(['id' => $item->products_id])->one();
                        $warehousemain->qautity = $warehousemain->qautity - $item->qautity;
                        $warehousemain->pricesale = number_format($warehousemain->pricesale, 2);
                        $warehousemain->save();

                    }

                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'ທ່ານໄດ້ໂອນສີີນຄ້າໃຫ້ສາຂາສໍາເລັດແລ້ວ.!'));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    /**
     * Finds the ProductTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductTransfer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAdditems()
    {
        $products = Products::find()->where(['status' => 1])->all();
        $model_item = new Itemtransfer();
        $model_item_arr = [];
        if (empty($_POST['product_id']) || empty($_POST['qauntity'])) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'ທ່ານຕ້ອງປ້ອນລາຍການໃຫ້ຖືກ.'));
        } else {
            $model_item->products_id = $_POST['product_id'];
            $model_item->qautity = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['qauntity']);
            $mainwarehouse = Products::find()->where(['id' => $model_item->products_id])->one();
            if ($mainwarehouse->qautity >= $model_item->qautity) {
                $purchase = \app\models\PurchaseItem::find()->where(['products_id' => $model_item->products_id])->orderBy('id DESC')->one();
                $model_item->price_buy = $purchase->pricebuy;

                $model_item_arr[] = $model_item;
                if (!empty(Yii::$app->session->get('model_items'))) {
                    \Yii::$app->session->set('model_items', array_merge($model_item_arr, Yii::$app->session->get('model_items')));
                } else {
                    \Yii::$app->session->set('model_items', $model_item_arr);
                }
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'ລາຍການນີ້ຈໍານວນສີນຄ້າບໍ່ພໍໂອນ.'));
            }
        }
        $product_arr = [];
        foreach ($products as $product) {
            $product_arr[$product->id] = $product->name;
        }
        return $this->renderAjax('list_items', ['product_arr' => $product_arr, 'model_item_arr' => $model_item_arr]);
    }

    public function actionDelitems()
    {
        $arr = [];
        foreach (Yii::$app->session->get('model_items') as $key => $model_item) {
            if ($key != $_POST['key_array']) {
                $arr[$key] = $model_item;
            } else {
                if (!empty($_POST['id'])) {
                    $model_del = Itemtransfer::find()->where(['id' => (int)$_POST['id']])->one();
                    $model_del->delete();
                }
            }
        }
        Yii::$app->session->set('model_items', $arr);
    }
}
