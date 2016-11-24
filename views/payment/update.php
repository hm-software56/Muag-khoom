<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = 'Update Payment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-update">
    <div class="line_bottom">ແກ້​ໄຂຈຳ​ນວນ​ລາຍ​ຈ່າຍ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
