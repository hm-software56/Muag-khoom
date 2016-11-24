<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecieveMoney */

$this->title = 'Create Recieve Money';
$this->params['breadcrumbs'][] = ['label' => 'Recieve Moneys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recieve-money-create">
    <div class="line_bottom">ປ້ອນ​ຈຳ​ນວນ​ລາຍ​ຮັບ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
