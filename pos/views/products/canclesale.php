<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
?>
<div class="row">
    <div class="col-md-12 " id="output">
        <div class="line_bottom">
            <div class="row">
                <div class="col-xs-12"><?=Yii::t('app', 'ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ')?></div>
            </div>
        </div>
        <div class=" table-responsive ">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            <?php
                            echo yii\helpers\Html::textInput('invoice_code', $invoice_code, [
                                'onchange' => '
                                    $.post( "index.php?r=products/repaortsale&invoice_code="+$(this).val(), function( data ) {
                                      $( "#output" ).html( data );
                                    });
                                ', 'placeholder' => Yii::t('app', 'ລະ​ຫັດບີນ'), 'id' => 'search', 'class' => 'form-control']);
                            ?>
                        </th>
                        <th><?=Yii::t('app', 'ຮູບພາບ')?></th>
                        <th><?=Yii::t('app', 'ຊື່​ສີ້ນ​ຄ້າ')?></th>
                        <th><?=Yii::t('app', 'ຈຳ​ນວນ')?></th>
                        <th><?=Yii::t('app', 'ລາ​ຄາ')?></th>
                        <th><?=Yii::t('app', 'ລວມ')?></th>
                        <th><?=Yii::t('app', 'ສ່ວນຫຼຸດ')?></th>
                        <th>
                            <?=
                            yii\jui\DatePicker::widget(['name' => 'date', 'value' => $date,
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'onchange' => '
                                    $.post( "index.php?r=products/canclesale&date="+$(this).val(), function( data ) {
                                      $( "#output" ).html( data );
                                    });
                                ', 'placeholder' => 'ວັນ​ທີ', 'class' => 'form-control',
                                ]
                            ])
                            ?>

                        </th>
                    </tr>

                </thead>
                <tbody>

                    <?php
                    $invoice_id = [];
                    $total = 0;
                    $total_discount = 0;
                    $i=0;
                    foreach ($invoices as $invoice) {
                        $models = \app\models\Sale::find()->where(['invoice_id' => $invoice->id])->all();
                        $array_pr = [];
                        foreach ($models as $model) {
                        $i++;
                            $total+= $model->price;
                            ?>
                    <tr>
                        <?php
                                if (!in_array($invoice->id, $invoice_id)) {
                                    ?>
                        <td rowspan="<?= count($models) ?>">
                            <?= $invoice->code ?>

                        </td>
                        <?php
                                }
                                ?>
                        <td><a title="<?= $model->products->name ?>" rel="popover"
                                data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>"><img
                                    src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>"
                                    class="img-rounded img-thumbnail img-responsive" width="50" /></a></td>
                        <td><?= $model->products->name ?></td>
                        <td>
                            <div id="qt<?=$i?>">
                                <?php
                                    echo yii\helpers\Html::a($model->qautity, '#', [
                                        'onclick' => "
                                            $.ajax({
                                            type     :'POST',
                                            cache    : false,
                                            url  : 'index.php?r=products/qautitycancle&idp=" . $model->products_id. "&qautity=" . $model->qautity . "&i=".$i. "&inv_id=".$invoice->id."',
                                            success  : function(response) {
                                                $('#qt".$i."').html(response);
                                               // document.getElementById('search').focus();
                                            }
                                            });return false;",
                                        'class' => "btn btn-sm bg-link"
                                    ]);
                                    ?>
                            </div>
                        </td>
                        <td><?=empty($model->qautity)?"0.00":number_format($model->price / $model->qautity, 2) ?></td>
                        <td><?= number_format($model->price, 2) ?></td>
                        <?php
                                if (!in_array($invoice->id, $invoice_id)) {
                                    ?>
                        <td rowspan="<?= count($models) ?>">
                            <?php
                                        $discount = \app\models\Discount::find()->where(['invoice_id' => $invoice->id])->one();
                                        if (!empty($discount)) {
                                            $total_discount+=$discount->discount;
                                            //echo number_format($discount->discount, 2);
                                        ?>
                            <div id="dc<?= $discount->id ?>">
                                <?php
                                            echo yii\helpers\Html::a(number_format($discount->discount, 2), '#', [
                                                'onclick' => "
                                                    $.ajax({
                                                    type     :'POST',
                                                    cache    : false,
                                                    url  : 'index.php?r=products/changediscount&dc=" . $discount->discount . "&dc_id=" . $discount->id . "',
                                                    success  : function(response) {
                                                        $('#dc" . $discount->id . "').html(response);
                                                    }
                                                    });return false;",
                                                'class' => "btn btn-sm bg-link"
                                            ]);
                                            ?>
                                <?php
                                        }
                                        ?>
                        </td>
                        <?php
                                }
                                ?>
                        <?php
                                if (!in_array($invoice->id, $invoice_id)) {
                                    ?>
                        <td rowspan="<?= count($models) ?>">
                            <?= $model->date ?>
                        </td>
                        <?php
                                }
                                ?>
                    </tr>
                    <?php
                            $invoice_id[] = $invoice->id;
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="5" align="right">​<b><?= Yii::t('app', 'ລວມ​ຈຳ​ນວນ​ເງີນ')?>​</b></td>
                        <td class="bg-blue"><b><?= number_format($total, 2) ?></b></td>
                        <td colspan="2" class="bg-yellow"><b><?= number_format($total_discount, 2) ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">​<b><?= Yii::t('app', 'ລວມ​ຈຳ​ນວນ​ເງີນ​ທັງ​ໝົດ')?></b></td>
                        <td colspan="3" class="bg-green"><b><?= number_format($total - $total_discount, 2) ?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/jquery1.8.min.js"></script>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/bootstrap2.2.1.min.js"></script>
<script>
// Add custom JS here
$('   a[rel = popover]').popover({
    html: true,
    trigger: 'hover',
    placement: 'right',
    content: function() {
        return '<img src = "' + $(this).data('img') + '" width = "150" />';
    }
});
</script>