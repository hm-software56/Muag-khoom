<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

if (Yii::$app->session->hasFlash('su')) {
    echo \kartik\alert\Alert::widget([
        'type' => \kartik\alert\Alert::TYPE_SUCCESS,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('su'),
        'showSeparator' => false,
        'delay' => 2000
    ]);
}
?>
<?php
Modal::begin(['clientOptions' => ['keyboard' => false], 'options' => ['id' => 'detail-modal',]])
?>
<div id='modalContent'></div>
<?php yii\bootstrap\Modal::end() ?>
<div class="row">
    <div class="col-md-12 ">
        <div class="line_bottom">
            <div class="row">
                <div class="col-xs-12">ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ</div>
                <?php $form = ActiveForm::begin(); ?>
                <div class="col-xs-8">
                    <?= yii\jui\DatePicker::widget(['name' => 'date_sale', 'value' => @$_POST['date_sale'], 'dateFormat' => 'yyyy-MM-dd', 'options' => [ 'class' => 'form-control input-sm']]) ?>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn bg-aqua btn-sm"><span class="glyphicon glyphicon-search"></span> ຄົ້ນ​ຫາ</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
        <div class=" table-responsive ">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ລະ​ຫັດບີນ</th>
                        <th>ຮູບພາບ</th>
                        <th>ຊື່​ສີ້ນ​ຄ້າ</th>
                        <th>ຈຳ​ນວນ</th>
                        <th>ລາ​ຄາ</th>
                        <th>ລວມ</th>
                        <th>ສ່ວນຫຼຸດ</th>
                        <th>ວັນ​ທີ</th>
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
                                        <?php
                                        /* echo yii\helpers\Html::a($model->products->id, '#', [

                                          'onclick' => "$('#detail-modal').modal('show');
                                          $.ajax({
                                          type: 'GET',
                                          cache: false,
                                          url: '" . Yii::$app->urlManager->createUrl(['products/cancle', 'id' => $model->products_id]) . "',
                                          success: function(response) {
                                          $('#detail-modal .modal-body').html(response);
                                          },
                                          });
                                          return false;
                                          ",
                                          ]); */
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                <td><a title="<?= $model->products->name ?>" rel="popover" data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>" class="img-rounded img-thumbnail img-responsive" width="50"/></a></td>
                                <td><?= $model->products->name ?></td>
                                <td><?= $model->qautity ?></td>
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
                        <td colspan="5" align="right">​<b>ລວມ​ຈຳ​ນວນ​ເງີນ​</b></td>
                        <td class="bg-blue"><b><?= number_format($total, 2) ?></b></td>
                        <td colspan="2" class="bg-yellow"><b><?= number_format($total_discount, 2) ?></b></td>
                    </tr>
                    <tr >
                        <td colspan="5" align="right">​<b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທັງ​ໝົດ</b></td>
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