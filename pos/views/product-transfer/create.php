<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductTransfer */

$this->title = Yii::t('app', 'ໂອນສີນຄ້າໃຫ້ສາຂາ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ໂອນສີນຄ້າ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-transfer-create">
    <div class="line_bottom"><?= Yii::t('app', 'ໂອນສີນຄ້າໃຫ້ສາຂາ') ?></div>
    <?= $this->render('_form', [
        'model' => $model,
        'product_arr' => $product_arr
    ]) ?>
</div>
