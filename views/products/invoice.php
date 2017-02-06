<?php
$profile = app\models\ShopProfile::find()->where(['id' => 1])->one();
?>
<div class="table-responsive" style="display: none" id="print">
    <table class="table">
        <tr>
            <td>
                <b><?= $profile->shop_name ?></b><br/>

                ເບີ​ໂທ: <?= $profile->telephone . " , " . $profile->phone_number ?> <br/>
                ອີ​ເມວ: <?= $profile->email ?> <br/>
                ທີ່​ຢູ່: <?= $profile->adress ?> <br/>
            </td>
            <td align="right">
                ເລກ​ທີ່: <?= $invoice->code ?><br/>
                <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $profile->logo ?>" class="img-responsive" width="100">
            </td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <td>ຊື່​ລູ​ກ​ຄ້າ: XXXXXXXXXXXX</td>
            <td align="right">ເບີ​ໂທ: 020 55045770</td>
            <td align="right">ວັ​ນ​ທີ: <?= $invoice->date ?></td>
        </tr>
        <table class="table table-striped" >
            <tr>
                <th>ລາຍ​ການ</th>
                <th>ຈຳ​ນວນ</th>
                <td align="right"><b>ລາ​ຄາ</b></td>
            </tr>
            <?php
            $total_prince = 0;
            $pro_id = [];
            if (!empty(\Yii::$app->session['product'])) {
                foreach (\Yii::$app->session['product'] as $order_p) {
                    if (!in_array(key($order_p), $pro_id)) {
                        $pro_id[] = key($order_p);
                        $product = \app\models\Products::find()->where(['id' => key($order_p)])->one();
                        ?>
                        <tr>
                            <td><?= $product->name ?></td>
                            <td>
                                <?php
                                echo $order_p['qautity'];
                                ?>
                            </td>
                            <td align="right"><?= number_format($product->pricesale * $order_p['qautity'], 2) ?> ກີບ</td>
                        </tr>
                        <?php
                        $total_prince+=$product->pricesale * $order_p['qautity'];
                    }
                }
            }
            ?>
            <tr>
                <td colspan="2" align="right">ລວມ​ຈຳ​ນວນ​ເງ​ີນ</td>
                <td align="right">​<b><?= number_format($total_prince, 2) ?> ກີບ</b></td>
            </tr>
            <tr>
                <td colspan="2" align="right">ລວມ​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ</td>
                <td align="right">​<b><?= number_format($total_prince + \Yii::$app->session['paychange'], 2) ?> ກີບ</b></td>
            </tr>
            <tr>
                <td colspan="2" align="right">ຈ​ຳ​ນວນ​​ເງີນຄ້າງ</td>
                <td align="right">​<b><?= number_format(\Yii::$app->session['paystill'], 2) ?> ກີບ</b></td>
            </tr>
            <tr>
                <td colspan="2" align="right">ຈ​ຳ​ນວນ​​ເງີນຖອນ</td>
                <td align="right">​<b><?= number_format(\Yii::$app->session['paychange'], 2) ?> ກີບ</b></td>
            </tr>
        </table>
</div>