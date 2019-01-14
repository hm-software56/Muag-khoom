<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Purchase */

$this->title = Yii::t('models', 'ເພີ່ມ​ຈັດຊື້');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '​ຈັດ​ຊື້'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-create">
    <div class="line_bottom"><?=Yii::t('app','ປ້ອນ​ສີນ​ຄ້າທີ່​ຊື້')?></div>
        <br/>
    <?= $this->render('_form', [
        'model' => $model,
        'product_arr'=>$product_arr
    ]) ?>

</div>
