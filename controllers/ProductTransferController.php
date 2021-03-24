<?php

namespace app\controllers;

use app\models\Itemtransfer;
use app\models\Products;
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
            $model->date = date('Y-m-d H:i:s');
            if ($model->save()) {
                foreach (Yii::$app->session->get('model_items') as $pd) {
                    $items = new Itemtransfer();
                    $items->products_id = $pd->products_id;
                    $items->qautity = $pd->qautity;
                    $items->price_buy = $pd->price_buy;
                    $items->product_transfer_id = $model->id;
                    $items->save();
                }
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

            $purchase = \app\models\PurchaseItem::find()->where(['products_id' => $model_item->products_id])->orderBy('id DESC')->one();
            $model_item->price_buy = $purchase->pricebuy;

            $model_item_arr[] = $model_item;
            if (!empty(Yii::$app->session->get('model_items'))) {
                \Yii::$app->session->set('model_items', array_merge($model_item_arr, Yii::$app->session->get('model_items')));
            } else {
                \Yii::$app->session->set('model_items', $model_item_arr);
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
