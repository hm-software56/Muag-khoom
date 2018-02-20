<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
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
                                    $.post( "index.php?r=products/repaortsale&date="+$(this).val(), function( data ) {
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
                    foreach ($invoices as $invoice) {

                        $models = \app\models\Sale::find()->where(['invoice_id' => $invoice->id])->all();
                        $array_pr = [];
                        foreach ($models as $model) {

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
                                <td><a title="<?= $model->products->name ?>" rel="popover" data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>" class="img-rounded img-thumbnail img-responsive" width="50"/></a></td>
                                <td><?= $model->products->name ?></td>
                                <td>
                                    <?php
                                    echo yii\helpers\Html::a($model->qautity, '#', [

                                        'onclick' => "$('#detail-modal').modal('show');
                                      $.ajax({
                                      type: 'GET',
                                      cache: false,
                                      url: '" . Yii::$app->urlManager->createUrl(['products/cancle', 'id' => $model->products_id, 'invoice_id' => $model->invoice_id]) . "',
                                      success: function(response) {
                                      $('#detail-modal .modal-body').html(response);
                                      },
                                      });
                                      return false;
                                      ",
                                    ]);
                                    ?></td>
                                <td><?= number_format($model->price / $model->qautity, 2) ?></td>
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
                        <td colspan="5" align="right">​<b><?= Yii::t('app', 'ລວມ​ຈຳ​ນວນ​ເງີນ')?>​</b></td>
                        <td class="bg-blue"><b><?= number_format($total, 2) ?></b></td>
                        <td colspan="2" class="bg-yellow"><b><?= number_format($total_discount, 2) ?></b></td>
                    </tr>
                    <tr >
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
        content: function () {
            return '<img src = "' + $(this).data('img') + '" width = "150" />';
        }
    });
</script>