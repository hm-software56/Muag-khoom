<?php

namespace app\controllers;

use Yii;
use app\models\Purchase;
use app\models\PurchaseSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PurchaseItem;
use app\models\Products;
use yii2mod\rbac\filters\AccessControl;

/**
 * PurchaseController implements the CRUD actions for Purchase model.
 */
class PurchaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' =>AccessControl::class,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'confirm' => ['POST'],
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
        } elseif (\Yii::$app->session['date_login'] < date('Ymd')) {
            unset(\Yii::$app->session['user']);
            $this->redirect(['site/login']);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Purchase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchase model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_items = PurchaseItem::find()->where(['purchase_id' => $id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_items' => $model_items
        ]);
    }

    /**
     * Creates a new Purchase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLoad()
    {
        //unset(Yii::$app->session['model_items']);
        $model = new Purchase();
        $model->detail = "Load old product";
        $model->date = date('Y-m-d');
        $model->currency_id = 1;
        $model->status = "confirm";
        if ($model->save()) {
            $product = Products::find()->all();
            foreach ($product as $item) {
                $model_item = new PurchaseItem;
                $model_item->date = $model->date;
                $model_item->pricebuy = $item->pricebuy;
                $model_item->qautity = $item->qautity;
                $model_item->products_id = $item->id;
                $model_item->purchase_id = $model->id;
                $model_item->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    public function actionCreate()
    {
        //unset(Yii::$app->session['model_items']);
        $model = new Purchase();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!empty(Yii::$app->session['model_items'])) {
                foreach (Yii::$app->session['model_items'] as $item) {
                    $model_item = new PurchaseItem;
                    $model_item->date = $model->date;
                    $model_item->pricebuy = $item->pricebuy;
                    $model_item->qautity = $item->qautity;
                    $model_item->products_id = $item->products_id;
                    $model_item->purchase_id = $model->id;
                    $model_item->save();
                }
                unset(Yii::$app->session['model_items']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
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
     * Updates an existing Purchase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->status == "confirm") {
            return $this->redirect(['index']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach (Yii::$app->session['model_items'] as $item) {
                $model_item = PurchaseItem::find()->where(['id' => $item->id])->one();
                if (empty($model_item)) {
                    $model_item = new PurchaseItem;
                }
                $model_item->date = $model->date;
                $model_item->pricebuy = $item->pricebuy;
                $model_item->qautity = $item->qautity;
                $model_item->products_id = $item->products_id;
                $model_item->purchase_id = $model->id;
                $model_item->save();
            }
            unset(Yii::$app->session['model_items']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        Yii::$app->session['model_items'] = PurchaseItem::find()->where(['purchase_id' => $model->id])->orderBy('id DESC')->all();
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

    public function actionPricebuy($id = null, $pricebuy, $upid = null)
    {
        if (!empty($upid)) {
            $model = PurchaseItem::find()->where(['id' => $upid])->one();
            $model->pricebuy = $pricebuy;
            $model->save();
            return "<div id=qt" . $model->id . ">" . Html::a(number_format($model->pricebuy, 2), '#', [
                    'onclick' => "
                                $.ajax({
                                type:'POST',
                                cache: false,
                                url:'index.php?r=purchase/pricebuy&id=" . $model->id . "&pricebuy=" . $model->pricebuy . "',
                                success:function(response) {
                                    $('#qt" . $model->id . "').html(response);
                                    document.getElementById('search').focus();
                                }
                                });return false;",
                    'class' => "btn btn-sm bg-link",
                ]) . "</div>";
        }
        return $this->renderAjax('updatepricebuy', ['pricebuy' => $pricebuy, 'id' => $id]);
    }

    /**
     * Deletes an existing Purchase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        if ($model->status != "confirm") {
            $purchase_items = PurchaseItem::find()->where(['purchase_id' => $model->id])->all();
            foreach ($purchase_items as $purchase_item) {
                $item = PurchaseItem::findOne($purchase_item->id);
                $item->delete();
            }
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Purchase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Purchase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchase::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('models', 'The requested page does not exist.'));
    }

    public function actionAddpurchaseitems()
    {
        $products = Products::find()->where(['status' => 1])->all();
        $model_item = new PurchaseItem;
        $model_item_arr = [];
        if (empty($_POST['product_id']) || empty($_POST['qauntity']) || empty($_POST['price'])) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'ທ່ານ​ຕ້ອງ​ປ້ອນ​ລາຍ​ການ​ໃຫ້​ຖືກ.'));
        } else {
            $model_item->products_id = $_POST['product_id'];
            $model_item->qautity = preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['qauntity']);
            $model_item->pricebuy = substr(preg_replace('/[^A-Za-z0-9\-]/', '', $_POST['price']), 0, -2);
            $model_item_arr[] = $model_item;
            if (!empty(Yii::$app->session['model_items'])) {
                Yii::$app->session['model_items'] = array_merge($model_item_arr, Yii::$app->session['model_items']);
            } else {
                Yii::$app->session['model_items'] = $model_item_arr;
            }

        }
        $product_arr = [];
        foreach ($products as $product) {
            $product_arr[$product->id] = $product->name;
        }

        return $this->renderAjax('list_form_items', ['product_arr' => $product_arr, 'model_item_arr' => $model_item_arr]);
    }

    public function actionDelpurchaseitems()
    {
        $arr = [];
        foreach (Yii::$app->session['model_items'] as $key => $model_item) {
            if ($key != $_POST['key_array']) {
                $arr[$key] = $model_item;
            } else {
                if (!empty($_POST['id'])) {
                    $model_del = PurchaseItem::find()->where(['id' => (int)$_POST['id']])->one();
                    $model_del->delete();
                }
            }
        }
        Yii::$app->session['model_items'] = $arr;
    }

    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->status = "confirm";
        if ($model->save()) {
            $purchase_items = PurchaseItem::find()->where(['purchase_id' => $model->id])->all();
            foreach ($purchase_items as $purchase_item) {
                $product = Products::find()->where(['id' => $purchase_item->products_id])->one();
                $qtt = $product->qautity + $purchase_item->qautity;
                $product->qautity = $qtt;
                $product->pricesale = number_format($product->pricesale, 2);
                $product->update();
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }
}
