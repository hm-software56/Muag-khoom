<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StillPay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="still-pay-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'price')->textInput(['data-a-sign' => Yii::t('app', 'ກີບ'), 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money_dao"]) ?>

    <?php // $form->field($model, 'date')->textInput() ?>

    <?php // $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
