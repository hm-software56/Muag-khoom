<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShopProfile */

$this->title = 'Update Shop Profile: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shop Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-profile-update">

    <div class="line_bottom">ຂໍ້​ມູນ​ຂອງ​ຮ້ານ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
