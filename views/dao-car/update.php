<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DaoCar */

$this->title = 'Update Dao Car: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dao Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dao-car-update">
    <div class="line_bottom">ແກ້ຈຳ​ນວນ​ຈ່າຍຄ່າ​ລົດ​ໃຫຍ່</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
