<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if (Yii::$app->session->hasFlash('su')) {
    echo kartik\alert\Alert::widget([
        'type' => kartik\alert\Alert::TYPE_SUCCESS,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('su'),
        'showSeparator' => false,
        'delay' => 500
    ]);
}
?>

<div id="output">
    <div class="row" >
        <div class="col-xs-2 col-md-2">
            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $product_sale->products->image ?>" class="thumbnail img-responsive" />
            <br/>
            <?= $product_sale->products->name ?>

        </div>
        <div class="col-xs-10 col-md-10">
            <table class="table table-responsive">
                <tr>
                    <th>ລາ​ຄາ</th>
                    <th>ບາ​ໂຄດ</th>
                    <th></th>
                </tr>
                <?php
                $barcodes = app\models\Barcode::find()->where(['products_id' => $product_sale->products_id, 'invoice_id' => $product_sale->invoice_id])->all();
                foreach ($barcodes as $barcode) {
                    ?>
                    <tr>
                        <td><?= number_format(($product_sale->price / $product_sale->qautity), 2) ?></td>
                        <td><?= $barcode->barcode ?></td>
                        <td>
                            <?php
                            echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove" style="color: red;"></span>', '#', [
                                'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/cancle&id=" . $product_sale->products_id . "&invoice_id=" . $product_sale->invoice_id . "&barcode=" . $barcode->barcode . "',
                       success  : function(response) {
                           $('#output').html(response);
                       }
                       });return false;",
                            ]);
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
