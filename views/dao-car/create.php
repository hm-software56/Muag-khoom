<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DaoCar */

$this->title = 'Create Dao Car';
$this->params['breadcrumbs'][] = ['label' => 'Dao Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dao-car-create">
    <div class="line_bottom">ປ້ອນ​ຈຳ​ນວນ​ລາຍ​ຈ່າຍ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
