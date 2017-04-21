<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <div class="line_bottom">ປ້ອນ​ປະ​ເພດ​ສີນ​ຄ້າ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
