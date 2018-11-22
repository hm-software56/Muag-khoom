<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Purchase */

$this->title = Yii::t('models', 'Create Purchase');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Purchases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-create">
    <div class="line_bottom">ປ້ອນ​ສີນ​ຄ້າທີ່​ຊື້</div>
        <br/>
    <?= $this->render('_form', [
        'model' => $model,
        'product_arr'=>$product_arr
    ]) ?>

</div>
