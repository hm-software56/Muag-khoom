<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShopProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-profile-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'logo')->fileInput()->label(Yii::t('app', 'ໂລໂກ')) ?>
    <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->logo ?>" width="50px"/>
    <?= $form->field($model, 'shop_name')->textInput(['maxlength' => true])->label(Yii::t('app', 'ຊື່ຮ້ານ')) ?>

    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true])->label(Yii::t('app', 'ໂທລະສັບຕັ້ງໂຕະ')) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true])->label(Yii::t('app', 'ໂທລະສັບມືຖື')) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(Yii::t('app', 'ອເມວ')) ?>

    <?= $form->field($model, 'adress')->textarea(['rows' => 6])->label(Yii::t('app', 'ທີ່ຢູ່')) ?>

    <?= $form->field($model, 'alert')->textInput(['maxlength' => true])->label(Yii::t('app', 'ແຈ້ງເຕຶອນສີນຄ້າໄກ້ໜົດ')) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'ບັນທືກ'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

