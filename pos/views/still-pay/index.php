<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use app\models\StillPay;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StillPaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Still Pays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="still-pay-index">

    <div class="row">
        <div class="col-md-8 col-xs-8 col-sm-8 ">
            <div class="line_bottom">
                ລາຍ​ການ​ໜິ​ຄ້າງ
            </div>
        </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ' . Yii::t('app', 'ປ້ອນ​ໜິ​ຄ້າງ'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>
<table class="table table-condensed table-bordered">
    <tr>
        <th colspan='2'>
        <?php $form = ActiveForm::begin(['action'=>'index.php?r=still-pay/index','method'=>'get']); ?>
        <?php
            echo $form->field($searchModel, 'name')->widget(Select2::classname(), [
                'data' =>yii\helpers\ArrayHelper::map(\app\models\Custommer::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => '===== ​ເລືອກ====',
                'onchange' => "this.form.submit()",
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ])->label('ລາຍ​ລະ​ອຽດ');
        ?>
        <?php ActiveForm::end(); ?>
        </th>
    <tr>
    <span id="search">
    <?php
    $sum=0;
    foreach ($dataProvider->models as $model) {
        $sum+=$model->price;
        ?>
    <tr id="del<?=$model->id?>">
        <td>
        <?=StillPay::details($model->id)?>
        </td>
        <td style="width:50px;">
        <?php
            echo yii\helpers\Html::a('<span class=" fa fa-thumbs-up"></span> ຈ່າຍ', '#', [
            'class'=>'btn btn-danger btn-sm',
            'onclick' => "
            $.ajax({
            type     :'POST',
            cache    : false,
            url  : 'index.php?r=still-pay/delete&id=" . $model->id ."',
            success  : function(response) {
            $('#del".$model->id."').html(response);
            }
            });return false;",
            ]);
        ?>
        </td>
    </tr>
    <?php
    }
    ?>
    </span>
    <tr>
        <td colspan="2" style="background-color:red; color:white">
        <b>ລວມ​ທັງ​ໝົດ: <?=number_format($sum,2)?> ກີບ</b>
        </td>
    </tr>
</table>
    
</div>
