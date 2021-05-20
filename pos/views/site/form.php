<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['action' => ['site/reg'], 'id' => 'forum_post', 'method' => 'post',]); ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label('ຊື່') ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('ນາມ​ສະ​ກຸນ') ?>
    <?php
    echo $form->field($model, 'username')->textInput(['maxlength' => true])->label('ຊື່​ເຂົ້າ​ລະ​ບົບ');
    ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('ລະ​ຫັດ​ເຂົ້າ​ລະ​ບົບ') ?>
    <?= $form->field($model, 'status')->hiddenInput(['value' => "1"])->label(false) ?>
    <?= $form->field($model, 'user_type')->hiddenInput(['value' => "User"])->label(false) ?>
    <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d')])->label(false) ?>
    <?= $form->field($model, 'user_role_id')->hiddenInput(['value' => 2])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ລົງ​ທະ​ບຽນ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
