<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DaoCar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dao-car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput(['data-a-sign' => 'ໂດ​ລາ', 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money_dao"])->label('ຈຳ​ນວນ​ເງີນ') ?>

    <?=
    $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ])->label(Yii::t('app', 'ວັນ​ທີ່​ຈ່າຍ'))
    ?>
    <?= $form->field($model, 'status')->dropDownList([ 'Paid' => 'ຈ່າຍ​ແລ້ວ', 'Saving' => '​ເກັບ​ໄວ້', 'remark' => '​ເອົ​າ​ໄປ​ເຮັດ​ແນວ​ອຶ່ນ',], ['prompt' => ''])->label('ສະ​ຖາ​ນະ') ?>
    <?= $form->field($model, 'remark')->textarea(['rows' => 2])->label('ໝາຍ​ເຫດ') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    jQuery(function ($) {
        $('#money').autoNumeric('init', {aSign: ' ໂດ​ລາ', pSign: 's'});
    });
</script>