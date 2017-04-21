<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Update Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <div class="line_bottom">ແກ້​ໄຂປະ​ເພດ​ສີນ​ຄ້າ</div>
    <br/>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
