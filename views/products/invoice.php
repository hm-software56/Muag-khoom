<?php
$profile = app\models\ShopProfile::find()->where(['id' => 1])->one();
$multi_currency_pay = app\models\PayMultiCurency::find()->where(['invoice_id' => $invoice->id])->one();
if (Yii::$app->user->identity->branch_id) {
    $profile_branch = \app\models\ProfileBranch::find()->where(['branch_id' => Yii::$app->user->identity->branch_id])->one();
    $branch = \app\models\Branch::find()->where(['id' => Yii::$app->user->identity->branch_id])->one();
    if ($profile_branch) {
        $profile->shop_name = $profile->shop_name . " - " . $branch->branch_name;
        $profile->telephone = $profile_branch->telephone;
        $profile->phone_number = $profile_branch->phone_number;
        $profile->adress = $profile_branch->address;
        $profile->email = $profile_branch->email;
    }
}
?>
<div style="display:none">
    <div class="table-responsive" id="print">
        <table class="table" style="font-size:11px !important;">
            <tr>
                <td>
                    <b><?= $profile->shop_name ?></b><br/>

                    <?= Yii::t('app', 'ເບີໂທ') ?>: <?= $profile->telephone . " , " . $profile->phone_number ?> <br/>
                    <?= Yii::t('app', 'ອີເມວ') ?>: <?= $profile->email ?> <br/>
                    <?= Yii::t('app', 'ທີ່ຢູ່') ?>: <?= $profile->adress ?> <br/>
                </td>
                <td align="right">
                    <?= Yii::t('app', 'ເລກທີ່') ?>: <?= $invoice->code ?><br/>
                    <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $profile->logo ?>"
                         class="img-responsive" width="100">
                </td>
            </tr>
        </table>
        <table class="table" style="font-size:11px !important;">
            <tr>
                <!--<td><?= Yii::t('app', 'ຊື່ລູກຄ້າ') ?>:................</td>
                <td align="right"><?= Yii::t('app', 'ເບີໂທ') ?>:...............</td>-->
                <td align="right" rowspan="3"><?= Yii::t('app', 'ວັນທີ') ?>: <?= $invoice->date ?></td>
            </tr>
            <table class="table table-striped" style="font-size:11px !important; ">
                <tr>
                    <th><?= Yii::t('app', 'ລາຍການ') ?></th>
                    <th>ຈຳນວນ</th>
                    <td align="right"><b><?= Yii::t('app', 'ລາຄາ') ?></b></td>
                </tr>
                <?php
                $total_prince = 0;
                $pro_id = [];
                if (!empty(\Yii::$app->session['product'])) {
                    foreach (\Yii::$app->session['product'] as $order_p => $qautity) {
                        if (!in_array($order_p, $pro_id)) {
                            $pro_id[] = $order_p;
                            $product = \app\models\Products::find()->where(['id' => $order_p])->one();
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
                            $total_prince += $product->pricesale * $qautity;
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="2" align="right"><?= Yii::t('app', 'ລວມຈຳນວນເງີນ') ?></td>
                    <td align="right">​<b><?= number_format($total_prince, 2) ?> <?= Yii::t('app', 'ກີບ') ?></b></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><?= Yii::t('app', 'ຈຳນວນ​ເງີນສ່ວນຫຼຸດ') ?></td>
                    <td align="right">​<b><?= number_format(\Yii::$app->session['discount'], 2) ?>
                            <?= Yii::t('app', 'ກີບ') ?></b></td>
                </tr>
                <tr>
                    <td colspan="2"
                        align="right"><?= Yii::t('app', 'ຈຳນວນເງີນຈ່າຍ') . "(" . Yii::t('app', 'LAK') . ")" ?>
                    </td>
                    <td align="right">​<b><?= number_format($multi_currency_pay->amount_kip, 2) ?></b></td>
                </tr>
                <tr>
                    <td colspan="2"
                        align="right"><?= Yii::t('app', 'ຈຳນວນເງ​ີນຈ່າຍ') . "(" . Yii::t('app', 'TH') . ")" ?>
                    </td>
                    <td align="right">​<b><?= number_format($multi_currency_pay->amount_th, 2) ?></b></td>
                </tr>
                <tr>
                    <td colspan="2"
                        align="right"><?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ') . "(" . Yii::t('app', 'USD') . ")" ?>
                    </td>
                    <td align="right">​<b><?= number_format($multi_currency_pay->amount_usd, 2) ?></b></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><?= Yii::t('app', 'ຈຳນວນເງີນທອນ') ?></td>
                    <td align="right">​<b><?= number_format(\Yii::$app->session['paychange'], 2) ?>
                            <?= Yii::t('app', 'ກີບ') ?></b></td>
                </tr>
            </table>
    </div>
</div>