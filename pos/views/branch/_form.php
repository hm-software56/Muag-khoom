<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile_branch, 'shop_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile_branch, 'telephone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile_branch, 'phone_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile_branch, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($profile_branch, 'address')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'status')->dropDownList([1=>Yii::t('app','ເປິດ'),0=>Yii::t('app','ປິດ')])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
