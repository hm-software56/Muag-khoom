<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\StillPay */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="still-pay-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-9">
        <?php 
            echo $form->field($model, 'custommer_id')->widget(Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(\app\models\Custommer::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => '===== ​ເລືອກ===='],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('ຜູ້​ຈະ​ຈ່າຍ');
        ?>
        </div>
        <div class="col-xs-3" style="padding-top:25px;">
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#smallShoes">
            ເພີ່ມຊື່​ຜູ້​ຄ້າງ
            </button>
        </div>
    </div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('ຊື່​ຜູ້​ເອົ​າ​ເຄື່ອງ') ?>
    <?= $form->field($model, 'details')->textarea(['rows' => 6])->label('ລາຍ​ລະ​ອຽດ​ໜີ້') ?>
    
    <?= $form->field($model, 'price')->textInput(['data-a-sign' => Yii::t('app', 'ກີບ'), 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money_dao"])->label('ລວມເງີນ​') ?>

    <?php // $form->field($model, 'date')->textInput() ?>

    <?php // $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $form = ActiveForm::begin(['action'=>'index.php?r=still-pay/createcus']); ?>
<!-- The modal -->
<div class="modal fade" id="smallShoes" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<h4 class="modal-title" id="modalLabelSmall">​ປ້ອນ​ຊື່</h4>
</div>

<div class="modal-body">
<input type="text"  class="form-control" name="name" maxlength="255" aria-invalid="false">
<br/>
<div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນ​ທືກ' : '<span class="fa fa-save"></span> ບັນ​ທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>
</div>

</div>
</div>
</div>
<?php ActiveForm::end(); ?>