<?php
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use app\models\Products;
$script = <<< JS
    $(function(){
    $('#save').click(function () {
        var mysave = $('#textBox').html();
        $('#hiddeninput').val(mysave);
    });
});
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-md-10">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-6">
            <label><?=Yii::t('app','ສີນ​ຄ້າ')?></label>
            <?php
                $products=Products::find()->where(['status'=>1])->all();
                $product_arr[]='All';
                foreach ($products as $product) {
                    $product_arr[$product->id]=$product->name;
                }
                echo Select2::widget([
                    'name' =>"product_id",
                    'id'=>'pro_id',
                    'data' => $product_arr,
                    'value'=>[Yii::$app->session['prdbc']],
                    'options' => [
                        'placeholder' =>Yii::t('app','​All'),
                        'multiple' => false,
                        'autocomplete'=>"off"
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-2">
            <label><?=Yii::t('app','ຈຳ​ນວນ')?></label>
            <input class="form-control"  name="number" type="text" value="<?=Yii::$app->session['nbbc']?>"/>
        </div>
        <div class="col-md-2" style="padding-top:25px">
        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-open-eye"></span> <?=Yii::t('app','ສ້າງບາ​ໂຄດ')?></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-2" align="right" style="padding-top:25px">
        <?php $form = ActiveForm::begin(['action'=>['products/bcodepdf']]); ?>
        <input id="hiddeninput" name="text" type="hidden"/>
        <button class="btn btn-danger" type="submit" id="save"><span class="glyphicon glyphicon-print"></span> <?=Yii::t('app','ພີມ​ບາ​ໂຄດ')?></button>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<hr/>
<div class="row"  id="textBox"  align="center">
    <?php
    if(!empty(Yii::$app->session['prdbc']))
    {
        $barcodes = \app\models\Products::find()->where(['id'=>Yii::$app->session['prdbc']])->all();
    }else{
        $barcodes = \app\models\Products::find()->all();
    }
    $i = 0;
    foreach ($barcodes as $barcode) {
        $i++;
        for ($a=1; $a<=Yii::$app->session['nbbc'];$a++) {
            ?>
            <div class="col-md-3" style="padding-bottom: 25px;width:25%; float: left;">
                <strong><?=$barcode->name?></strong><br />
                <img id="barcode<?= $i.$a ?>">
                <br />
                <?=number_format($barcode->pricesale, 2)?> ​ກີບ
            </div>
        <?php
        }
    }
    ?>
</div>