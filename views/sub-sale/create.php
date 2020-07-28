<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubSale */

$this->title = Yii::t('app', 'ປະເພດຂາຍຍ່ອຍ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ປະເພດຂາຍຍ່ອຍ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-sale-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
