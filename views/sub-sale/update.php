<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubSale */

$this->title = Yii::t('app', 'Update Sub Sale: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sub Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sub-sale-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
