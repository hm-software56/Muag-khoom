<?= $this->render('invoice', ['invoice' => $invoice]);
?>
<div class="row table-responsive" style="height: 450px;">
    <table class="table table-striped" >
        <tr>
            <th>ລາຍ​ການ</th>
            <th>ຈຳ​ນວນ</th>
            <th>ລາ​ຄາ</th>
        </tr>
        <?php
        $total_prince = 0;
        $pro_id = [];
        if (!empty(\Yii::$app->session['product'])) {
            foreach (\Yii::$app->session['product'] as $order_p=>$qautity) {
                if (!in_array($order_p, $pro_id)) {
                    $pro_id[] = $order_p;
                    $product = \app\models\Products::find()->where(['id' =>$order_p])->one();
                    ?>
                    <tr>
                        <td><?= $product->name ?></td>
                        <td>
                            <?php
                            echo $qautity;
                            ?>
                        </td>
                        <td align="right"><?= number_format($product->pricesale * $qautity, 2) ?></td>
                    </tr>
                    <?php
                    $total_prince+=$product->pricesale * $qautity;
                }
            }
        }
        ?>
        <tr>
            <td colspan="2" align="right">ລວມ​ຈຳ​ນວນ​ເງ​ີນ</td>
            <td align="right">​<b><?= number_format($total_prince, 2) ?></b></td>
        </tr>

        <tr>
            <td colspan="2" align="right">ຈຳ​ນວນ​ເງ​ີນສ່ວນຫຼຸດ</td>
            <td align="right">​<b><?= number_format(\Yii::$app->session['discount'], 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="right">ລວມ​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ</td>
            <td align="right">​<b><?= number_format(($total_prince + \Yii::$app->session['paychange']) - \Yii::$app->session['discount'], 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="right">ຈ​ຳ​ນວນ​​ເງີນຄ້າງ</td>
            <td align="right">​<b><?= number_format(\Yii::$app->session['paystill'], 2) ?></b></td>
        </tr>
        <tr>
            <td colspan="2" align="right">ຈ​ຳ​ນວນ​​ເງີນຖອນ</td>
            <td align="right">​<b><?= number_format(\Yii::$app->session['paychange'], 2) ?></b></td>
        </tr>
    </table>
</div>
<div class="row" style="border-top: 2px green solid; padding-top: 2px;">
    <div class="col-md-6 ">
        <?php
        echo \yii2assets\printthis\PrintThis::widget([
            'htmlOptions' => [
                'id' => 'print',
                'btnClass' => 'btn bg-red',
                'btnId' => 'btnPrintThis',
                'btnText' => 'ພີມ​ໃບ​ບີນ',
                'btnIcon' => 'glyphicon glyphicon-print'
            ],
            'options' => [
                'debug' => false,
                'importCSS' => true,
                'importStyle' => false,
                'loadCSS' => "path/to/my.css",
                'pageTitle' => "",
                'removeInline' => true,
                'printDelay' => 333,
                'header' => null,
                'formValues' => true,
            ]
        ]);
        ?>
    </div>
    <div class="col-md-6 " align="right">
        <?php
        echo yii\helpers\Html::a('ສັ່ງ​ຊື້​ຕໍ່ <span class="glyphicon glyphicon-forward"></span>', '#', [
            'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/ordercancle',
                       success  : function(response) {
                           $('#output').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
            'class' => "btn btn-large bg-green"
        ]);
        ?>
    </div>
</div>