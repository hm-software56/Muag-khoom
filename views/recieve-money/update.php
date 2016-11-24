<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecieveMoney */

$this->title = 'Update Recieve Money: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recieve Moneys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recieve-money-update">
    <div class="line_bottom">ແກ້​ໄຂຈຳ​ນວນ​ລາຍ​ຮັບ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
