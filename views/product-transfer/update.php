<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductTransfer */

$this->title = Yii::t('app', 'Update Product Transfer: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Transfers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-transfer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'product_arr' => $product_arr
    ]) ?>

</div>
