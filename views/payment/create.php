<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = 'Create Payment';
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-create">
    <div class="line_bottom">ປ້ອນ​ຈຳ​ນວນ​ລາຍ​ຈ່າຍ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
