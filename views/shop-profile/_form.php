<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShopProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-profile-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'logo')->fileInput()->label('ໂລ​ໂກ') ?>
    <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->logo ?>" width="50px"/>
    <?= $form->field($model, 'shop_name')->textInput(['maxlength' => true])->label('ຊື່​ຮ້ານ') ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true])->label('ໂທ​ລະ​ສັບ​ຕັ້ງ​ໂຕະ') ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true])->label('ໂທ​ລະ​ສັບ​ມື​ຖື') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('ອີ​ເມວ') ?>

    <?= $form->field($model, 'adress')->textarea(['rows' => 6])->label('ທີ່​ຢູ່') ?>

    <div class="form-group">
        <?= Html::submitButton('ບັນ​ທ​ືກ', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
