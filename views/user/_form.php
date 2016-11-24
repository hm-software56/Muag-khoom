<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use karpoff\icrop\CropImageUpload;
use budyaga\cropper\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'disable-submit-buttons', 'enctype' => 'multipart/form-data', 'autocomplete' => "off"]]); ?>

    <?= $form->field($model, 'photo')->fileInput()->label('ຮູບ') ?>
    <?php // $form->field($model, 'photo')->widget(karpoff\icrop\CropImageUpload::className()) ?>
    <?php
//    echo $form->field($model, 'photo')->widget(Widget::className(), [
//        'uploadUrl' => Url::toRoute('/user/user/uploadPhoto'),
//    ])
    ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label('ຊື່') ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('ນາມ​ສະ​ກຸນ') ?>
    <?php
    if (isset($_GET['prof'])) {
        echo $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => 'disabled'])->label('ຊື່​ເຂົ້າ​ລະ​ບົບ');
    } else {
        echo $form->field($model, 'username')->textInput(['maxlength' => true])->label('ຊື່​ເຂົ້າ​ລະ​ບົບ');
    }
    ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('ລະ​ຫັດ​ເຂົ້າ​ລະ​ບົບ') ?>
    <?php
    if (!isset($_GET['prof'])) {
        ?>
        <?= $form->field($model, 'status')->dropDownList([ '1' => 'ເປິດ', '​0' => 'ປິດ',], ['prompt' => ''])->label('ສະ​ຖາ​ນະ') ?>

        <?= $form->field($model, 'user_type')->dropDownList([ 'Admin' => 'ຜູ້​ຄຸ້ມລະ​ບົບ', 'User' => '​ຜູ້​ໃຊ້​ລະ​ບົບ',], ['prompt' => ''])->label('ສິດ​ຜູ້​ໃຊ້ລະ​ບົບ') ?>

        <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d')])->label(false) ?>
        <?php
    }
    ?>
    <?= $form->field($model, 'user_role_id')->hiddenInput(['value' => Yii::$app->session['user']->user_role_id])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
