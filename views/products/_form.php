<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>
<br/>
<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qautity')->textInput() ?>

    <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d')])->label(FALSE) ?>
    <?= $form->field($model, 'pricebuy')->textInput(['data-a-sign' => 'ກີບ', 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money_dao"]) ?>

    <?= $form->field($model, 'pricesale')->textInput(['data-a-sign' => 'ກີບ', 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money"]) ?>


    <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>
    <?php
    if (!empty($model->image)) {
        ?>
        <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="img-responsive" />

        <br/>
        <?php
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
