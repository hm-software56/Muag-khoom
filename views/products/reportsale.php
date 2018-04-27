<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
$this->title=Yii::t('app','Report');
?>
<?php
Modal::begin([
    'id' => 'detail-modal',
    'size' => 'modal-lg',
]);
?>
<div id="modalContent"></div>
<?php
Modal::end();
?>
<div class="row" >
    <div class="col-md-12 " id="output">
        <div class="line_bottom">
            <div class="row">
                <div class="col-xs-12"><?=Yii::t('app', 'ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ')?></div>
            </div>

        </div><br/>
        <table >
            <tr>
                <td>
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>      
                        <?=
                        yii\jui\DatePicker::widget([
                            'name' => 'date', 'value' => Yii::$app->session['date'],
                            'dateFormat' => 'yyyy-MM-dd',
                            'clientOptions' => [
                                'changeMonth' => true,
                                'changeYear' => true,
                            ],
                            'options' => [
                                
                                'onchange' => '
                                                    $.post( "index.php?r=products/repaortsale&date="+$(this).val(), function( data ) {
                                                    $( "#output" ).html( data );
                                                    });
                                                ', 'placeholder' => 'ວັນ​ທີ', 'class' => 'form-control',
                            ]
                        ])
                        ?>
                    </div>
                </td>
                <td><div style="padding:10px;">ຫາ</div></td>
                <td>
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-calendar"></i>      
                        <?=
                        yii\jui\DatePicker::widget([
                            'name' => 'date_to', 'value' => Yii::$app->session['date_to'],
                            'dateFormat' => 'yyyy-MM-dd',
                            'clientOptions' => [
                                'changeMonth' => true,
                                'changeYear' => true,
                            ],
                            'options' => [
                                'onchange' => '
                                                    $.post( "index.php?r=products/repaortsale&date_to="+$(this).val(), function( data ) {
                                                    $( "#output" ).html( data );
                                                    });
                                                ', 'placeholder' => 'ວັນ​ທີ', 'class' => 'form-control',
                            ]
                        ])
                        ?>
                    </div>
                </td>
            </tr>
        </table>
        
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
                        <th><?=Yii::t('app', 'ລາ​ຄາຂາຍ')?></th>
                        <th><?=Yii::t('app', 'ລວມລາ​ຄາຂາຍ')?></th>
                        <th><?=Yii::t('app', 'ສ່ວນຫຼຸດ')?></th>
                        <th><?= Yii::t('app', 'ວັນ​ທີ່') ?></th>
                    </tr>

                </thead>
                <tbody>

                    <?php
                    $invoice_id = [];
                    $total = 0;
                    $total_discount = 0;
                    $total_profit=0;
                    foreach ($invoices as $invoice) {

                        $models = \app\models\Sale::find()->where(['invoice_id' => $invoice->id])->all();
                        $array_pr = [];
                        foreach ($models as $model) {

                            $total+= $model->price;
                            $total_profit+=$model->profit_price;
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
                                <td><a title="<?= $model->products->name ?>" rel="popover" data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>" class="img-rounded img-thumbnail img-responsive" width="50"/></a></td>
                                <td><?= $model->products->name ?></td>
                                <td>
                                    <?php
                                    echo $model->qautity;
                                    ?></td>
                                <td><?= empty($model->qautity)?"0.00":number_format($model->price / $model->qautity, 2) ?></td>
                                <td><?= number_format($model->price, 2) ?></td>
                                <?php
                                if (!in_array($invoice->id, $invoice_id)) {
                                    ?>
                                    <td rowspan="<?= count($models) ?>">
                                        <?php
                                        $discount = \app\models\Discount::find()->where(['invoice_id' => $invoice->id])->one();
                                        if (!empty($discount)) {
                                            $total_discount+=$discount->discount;
                                            echo number_format($discount->discount, 2);
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
                        <td colspan="5" align="right">​<b><?= Yii::t('app', 'ລວມ​ຈຳ​ນວນ​ເງີນທີ່​ຂາຍ')?>​</b></td>
                        <td class="bg-blue"><b><?= number_format($total, 2) ?></b></td>
                        <td align="right"><b><b><?= Yii::t('app', 'ສ່ວນຫຼຸດ') ?></b></td>
                        <td  class="bg-yellow"><?= number_format($total_discount, 2) ?></b></td>
                    </tr>
                    <tr >
                        <td colspan="5" align="right">​<b><?= Yii::t('app', 'ຕົ້ນທຶນ')?></b></td>
                        <td  class="bg-red"><b><?= number_format($total -$total_profit, 2) ?></b></td>
                        <td align="right"><b><b><?= Yii::t('app', 'ກຳ​ໄລ') ?></b></td>
                        <td  class="bg-green"><b><?= number_format($total_profit- $total_discount, 2) ?></b></td>
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
        content: function () {
            return '<img src = "' + $(this).data('img') + '" width = "150" />';
        }
    });
</script>