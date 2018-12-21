<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

?>
<br/>
<div class="products-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php // $form->field($model, 'category_id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']) ?>
    <?php
    echo $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => yii\helpers\ArrayHelper::map(\app\models\Category::getList(), 'id', 'name'),
        'options' => [
            'placeholder' => 'Select a state ...',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
 
    ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d')])->label(FALSE) ?>
    
    <?= $form->field($model, 'pricesale')->textInput(['data-a-sign' => Yii::$app->session['currency']->name, 'data-a-dec' => ".", 'data-a-sep' => ",", 'id' => "money"]) ?>


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
        <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-save"></span>'. Yii::t('app', 'ບັນ​ທືກ') : '<span class="fa fa-save"></span> '. Yii::t('app', 'ບັນ​ທືກ'), ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
