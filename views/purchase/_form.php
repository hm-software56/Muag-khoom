<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Currency;
$currency=Currency::find()->where(['id'=>1])->one();
//echo $currency->code; $vl*$ra
$a=7200-100;
echo round(1569601.6, 0); 

/* @var $this yii\web\View */
/* @var $model app\models\Purchase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 2]) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'currency_id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Currency::find()->orderBy('base_currency DESC')->all(), 'id', 'name'), ['class' => 'form-control']) ?>
    
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class,  [
                'dateFormat' => 'yyyy-MM-dd',
                'clientOptions' =>[
                    'showAnim'=>'fold',
                    'changeMonth'=> true,
                    'changeYear'=> true
                ],
                'options' => ['class' => 'form-control']
                ]) ?>
        </div>
    </div>

    <?php
    if(empty($model->id))
    {
        echo $form->field($model, 'status')->hiddenInput(['value' => 'save','maxlength' => true])->label(false);
    }
   // $form->field($model, 'status')->dropDownList([ 'save' => 'Save', 'confirm' => 'Confirm', 'cancle' => 'Cancle', ], ['prompt' => '']) 
   
   ?>
  <div id="list_pt">
   <?php
    echo Yii::$app->controller->renderPartial('list_form_items',['product_arr'=>$product_arr]);
   ?>
   </div>
    <div class="form-group" align="right">
        <?= Html::submitButton('<i class="fa fa-floppy-o" aria-hidden="true"></i> '.Yii::t('models', 'ບັນ​ທືກ'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
