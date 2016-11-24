<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Create Products';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <div class="line_bottom">ປ້ອນ​ສີ້ນ​ຄ້າ</div>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
