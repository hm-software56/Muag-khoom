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

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label('ຊື່') ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label('ນາມສະກຸນ') ?>
    <?php
    if (isset($_GET['prof'])) {
        echo $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => 'disabled'])->label('ຊື່ເຂົ້າລະບົບ');
    } else {
        echo $form->field($model, 'username')->textInput(['maxlength' => true])->label('ຊື່ເຂົ້າລະບົບ');
    }
    ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('ລະຫັດເຂົ້າລະບົບ') ?>
    <?php
    if (!isset($_GET['prof'])) {
        ?>
        <?php
        echo $form->field($model, 'branch_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(\app\models\Branch::find()->where(['status' => 1])->all(), 'id', 'branch_name'),
            'options' => [
                'placeholder' => Yii::t('app','=== ເລຶອກສາຂາ ==='),
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(Yii::t('app','ສາຂາ'));

        ?>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'ເປິດ', '0' => 'ປິດ',], ['prompt' => ''])->label('ສະຖານະ') ?>

        <?= $form->field($model, 'user_type')->dropDownList(['Admin' => 'ຜູ້ຄຸ້ມລະບົບ', 'User' => 'ຜູ້ໃຊ້ລະບົບ', 'POS' => 'ຜູ້ຂາຍໜ້າຮ້ານ'], ['prompt' => ''])->label('ສິດຜູ້ໃຊ້ລະບົບ') ?>

        <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d')])->label(false) ?>
        <?php
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span> ບັນທືກ' : '<span class="fa fa-save"></span> ບັນທືກ', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
