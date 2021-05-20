<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Update Products: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','​ສີ​ນ​ຄ້າ'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app','ແກ້​ໄຂ');
?>
<div class="products-update">

    <div class="line_bottom"><?=Yii::t('app','ແກ້​ໄຂສີ້ນ​ຄ້າ')?></div>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
