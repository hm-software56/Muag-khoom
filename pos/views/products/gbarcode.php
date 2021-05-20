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
    <div class="col-md-8">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-6">
            <label><?= Yii::t('app', 'ສີນ​ຄ້າ') ?></label>
            <?php
            $products = Products::find()->where(['status' => 1])->all();
            $product_arr[] = Yii::t('app', 'ສີນ​ຄ້າ​ທັງ​ໝົດ');
            foreach ($products as $product) {
                $product_arr[$product->id] = $product->name;
            }
            echo Select2::widget([
                'name' => "product_id",
                'id' => 'pro_id',
                'data' => $product_arr,
                'value' => [Yii::$app->session['prdbc']],
                'options' => [
                    'placeholder' => Yii::t('app', '​All'),
                    'multiple' => false,
                    'autocomplete' => "off"
                ],
            ]);
            ?>
        </div>
        <div class="col-md-2">
            <label><?= Yii::t('app', 'ຈຳ​ນວນ') ?></label>
            <input class="form-control" name="number" type="text" value="<?= Yii::$app->session['nbbc'] ?>"/>
        </div>
        <div class="col-md-2" style="padding-top:25px">
            <button class="btn btn-primary" type="submit"><span
                        class="glyphicon glyphicon-open-eye"></span> <?= Yii::t('app', 'ສ້າງບາ​ໂຄດ') ?></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-2" align="right" style="padding-top:25px">
        <?php
        echo \yii2assets\printthis\PrintThis::widget([
            'htmlOptions' => [
                'id' => 'printOnlyBarcode',
                'btnClass' => 'btn bg-green',
                'btnId' => 'btnPrintThis',
                'btnText' => 'ພີມບາໂຄດ',
                'btnIcon' => 'glyphicon glyphicon-print',
            ],
            'options' => [
                'debug' => false,
                //'importCSS' => true,
                // 'importStyle' => false,
                // 'loadCSS' => "path/to/my.css",
                // 'pageTitle' => "",
                //  'removeInline' => true,
                //  'printDelay' => 333,
                'header' => null,
                'formValues' => true,
            ]
        ]);
        ?>
    </div>
    <div class="col-md-2" align="right" style="padding-top:25px">
        <?php $form = ActiveForm::begin(['action' => ['products/bcodepdf']]); ?>
        <input id="hiddeninput" name="text" type="hidden"/>
        <button class="btn btn-danger" type="submit" id="save" formtarget="_blank"><span
                    class="glyphicon glyphicon-print"></span> <?= Yii::t('app', 'PDF ບາໂຄດ') ?></button>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<hr/>
<div class="row" id="textBox" align="center">
    <?php
    if (!empty(Yii::$app->session['prdbc'])) {
        $products = \app\models\Products::find()->where(['id' => Yii::$app->session['prdbc']])->all();
    } else {
        $products = \app\models\Products::find()->all();
    }
    $i = 0;
    foreach ($products as $product) {
        $c = date('sdmY') . random_int(11, 99);
        $barcode = \app\models\Barcode::find()->where(['products_id' => $product->id])->one();
        if (empty($barcode)) {
            $barcode = new \app\models\Barcode();
            $barcode->barcode = $c;
            $barcode->status = 1;
            $barcode->products_id = $product->id;
            $barcode->save();
        }
        $i++;
        for ($a = 1; $a <= Yii::$app->session['nbbc']; $a++) {
            ?>
            <div class="col-md-3" id="w" style="padding-bottom: 28px;width:25%; float: left; ">
                <strong><?= $product->name ?></strong><br/>
                <img class="barcode<?= $i . $a ?>"
                     jsbarcode-format="EAN13"
                     jsbarcode-height='30'
                     jsbarcode-width='2.0'
                     jsbarcode-value="<?= $barcode->barcode ?>"
                     jsbarcode-textmargin="0"
                     jsbarcode-fontoptions="bold">
                </img>
                <br/>
                <span style="color:red;"><?= number_format($product->pricesale, 2) ?> ​ກີບ</span>
            </div>
            <script>
                JsBarcode(".barcode<?= $i . $a ?>").init();
            </script>
            <?php
        }
    }
    ?>
</div>

<!-- Use for print only barcode -->
<div class="row" id="printOnlyBarcode" align="center">
    <?php
    if (!empty(Yii::$app->session['prdbc'])) {
        $products = \app\models\Products::find()->where(['id' => Yii::$app->session['prdbc']])->all();
    } else {
        $products = \app\models\Products::find()->all();
    }
    $i = 0;
    foreach ($products as $product) {
        $barcode = \app\models\Barcode::find()->where(['products_id' => $product->id])->one();
        $i++;
        for ($a = 1; $a <= Yii::$app->session['nbbc']; $a++) {
            ?>
            <div class="col-md-3" id="w" style="padding-bottom: 28px;width:100%; float: left; ">
                <strong style="font-size: 10px"><?= $product->name ?></strong><br/>
                <img class="barcode<?= $i . $a ?>"
                     jsbarcode-format="EAN13"
                     jsbarcode-height='20'
                     jsbarcode-width='1.9'
                     jsbarcode-value="<?= $barcode->barcode ?>"
                     jsbarcode-textmargin="0"
                     jsbarcode-fontoptions="bold">
                </img>
                <br/>
                <span style="color:red; font-size: 10px"><?= number_format($product->pricesale, 2) ?> ​ກີບ</span>
            </div>
            <script>
                JsBarcode(".barcode<?= $i . $a ?>").init();
            </script>
            <?php
        }
    }
    ?>
</div>