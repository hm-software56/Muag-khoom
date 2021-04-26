<?php

namespace app\controllers;

class WarehouseController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListproductwarehouse()
    {
        return $this->render('list_product_warehouse');
    }

}
