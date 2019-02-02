<?php
$profile = app\models\ShopProfile::find()->where(['id' => 1])->one();
$multi_currency_pay = app\models\PayMultiCurency::find()->where(['invoice_id' => $invoice->id])->one();
?>
<div  style="display: none">
<div class="table-responsive" id="print" >
    <table class="table" style="font-size:9px !important;">
        <tr>
            <td>
                <b><?= $profile->shop_name ?></b><br/>

                <?= Yii::t('app', 'ເບີ​ໂທ')?>: <?= $profile->telephone . " , " . $profile->phone_number ?> <br/>
                <?= Yii::t('app', 'ອີ​ເມວ')?>: <?= $profile->email ?> <br/>
                <?= Yii::t('app', 'ທີ່​ຢູ່')?>: <?= $profile->adress ?> <br/>
            </td>
            <td align="right">
                <?= Yii::t('app', 'ເລກ​ທີ່')?>: <?= $invoice->code ?><br/>
                <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $profile->logo ?>" class="img-responsive" width="100">
            </td>
        </tr>
    </table>
    <table class="table" style="font-size:9px !important;">
        <tr>
            <td><?= Yii::t('app', 'ຊື່​ລູ​ກ​ຄ້າ')?>:................</td>
            <td align="right"><?= Yii::t('app', 'ເບີ​ໂທ')?>:...............</td>
            <td align="right"><?=Yii::t('app', 'ວັ​ນ​ທີ')?>: <?= $invoice->date ?></td>
        </tr>
        <table class="table table-striped" style="font-size:9px !important;" >
            <tr>
                <th><?= Yii::t('app', 'ລາຍ​ການ')?></th>
                <th>ຈຳ​ນວນ</th>
                <td align="right"><b><?= Yii::t('app', 'ລາ​ຄາ')?></b></td>
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
                            <td align="right"><?= number_format($product->pricesale * $qautity, 2) ?> ກີບ</td>
                        </tr>
                        <?php
                        $total_prince+=$product->pricesale * $qautity;
                    }
                }
            }
            ?>
            <tr>
                <td colspan="2" align="right"><?= Yii::t('app', 'ລວມ​ຈຳ​ນວນ​ເງ​ີນ')?></td>
                <td align="right">​<b><?= number_format($total_prince, 2) ?> <?= Yii::t('app', 'ກີບ')?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><?= Yii::t('app', 'ຈຳ​ນວນ​ເງ​ີນສ່ວນຫຼຸດ')?></td>
                <td align="right">​<b><?= number_format(\Yii::$app->session['discount'], 2) ?> <?= Yii::t('app', 'ກີບ')?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ')."(".Yii::t('app', 'LAK').")"?></td>
                <td align="right">​<b><?= number_format($multi_currency_pay->amount_kip, 2) ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ')."(".Yii::t('app', 'TH').")"?></td>
                <td align="right">​<b><?= number_format($multi_currency_pay->amount_th, 2) ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ')."(".Yii::t('app', 'USD').")"?></td>
                <td align="right">​<b><?= number_format($multi_currency_pay->amount_usd, 2) ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><?= Yii::t('app', 'ຈ​ຳ​ນວນ​​ເງີນຖອນ')?></td>
                <td align="right">​<b><?= number_format(\Yii::$app->session['paychange'], 2) ?> <?= Yii::t('app','ກີບ')?></b></td>
            </tr>
        </table>
</div>
</div>