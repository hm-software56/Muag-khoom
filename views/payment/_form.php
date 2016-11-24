<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="payment-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'options' => ['autocomplete' => "off"], 'id' => 'payment-form']); ?>
    <?= $form->field($model, 'type_pay_id')->dropDownList(ArrayHelper::map(app\models\TypePay::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => ''])->label(Yii::t('app', 'ປະ​ເພດ​ໃຊ້​ຈ່າຍ')) ?>
    <?= $form->field($model, 'amount')->textInput(['data-a-sign' => 'ກີບ', 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money"])->label('ຈຳ​ນວນ​ເງີນ') ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 2])->label('ອະ​ທີ​ບາຍ​ຈ່າຍ​ຫຍັງ') ?>
    <?=
    $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ])->label(Yii::t('app', 'ວັນ​ທີ່​ຈ່າຍ'))
    ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->session['user']->id])->label(FALSE) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    jQuery(function ($) {
        $('#money').autoNumeric('init', {aSign: ' ກີບ', pSign: 's'});
    });
</script>