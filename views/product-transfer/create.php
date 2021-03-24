<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductTransfer */

$this->title = Yii::t('app', 'Create Product Transfer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Transfers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-transfer-create">

    <?= $this->render('_form', [
        'model' => $model,
        'product_arr' => $product_arr
    ]) ?>

</div>
