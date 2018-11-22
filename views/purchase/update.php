<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Purchase */

$this->title = Yii::t('models', 'Update Purchase: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Purchases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('models', 'Update');
?>
<div class="purchase-update">

   <div class="line_bottom"><?=Yii::t('app','​ແກ້​ໄຂ​ສີນ​ຄ້າ​ທີ​ຊື້')?></div>

    <?= $this->render('_form', [
        'model' => $model,
        'product_arr'=>$product_arr
    ]) ?>

</div>
