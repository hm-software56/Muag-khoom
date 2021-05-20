<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title =Yii::t('app','ເພີ່ມ​ສີນ​ຄ້າ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','​ສີ​ນ​ຄ້າ'), 'url' => ['index']];
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
