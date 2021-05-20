<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-transfer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->hiddenInput(['value' => 0])->label(false) ?>

    <?php
    echo $form->field($model, 'branch_id')->widget(\kartik\select2\Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\app\models\Branch::find()->where(['status' => 1])->all(), 'id', 'branch_name'),
        'options' => [
            'placeholder' => Yii::t('app', '=== ເລຶອກສາຂາ ==='),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(Yii::t('app', 'ສາຂາ'));

    ?>

    <div id="list_pt">
        <?php
        echo Yii::$app->controller->renderPartial('list_items', ['product_arr' => $product_arr]);
        ?>
    </div>
    <div class="form-group" align="right">
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> ' . Yii::t('models', 'ບັນ​ທືກ'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
