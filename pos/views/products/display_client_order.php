<?php

use yii\helpers\Html;
use yii\web\UrlManager;

$this->title = 'ສະແດງໃຫ້ຜູ້ຊື້ເຫັນ';
?>
<?php
if (\Yii::$app->session['width_screen'] > Yii::$app->params['width_disable'] and \Yii::$app->session['height_screen'] > Yii::$app->params['height_disable']) ///for PC
{
$h = Yii::$app->session['height_screen'];
if (!empty(\Yii::$app->session['product'])) {
    $h = Yii::$app->session['height_screen'];
}
?>
<div class="row table-responsive" style="height:<?= $h . 'px' ?>;">
    <?php
    }else{ /// for mobile
    if (!empty(\Yii::$app->session['product']) && count(\Yii::$app->session['product']) > 2)
    {
    ?>
    <div class="row table-responsive"
         style="overflow-y:auto; height:<?= \Yii::$app->session['height_screen'] / 3 . 'px' ?>;">
        <?php
        }else{
        ?>
        <div class="row table-responsive">
            <?php
            }
            }
            ?>

            <table class="table table-striped ">
                <tr style="background: #f1e1e5">
                    <th align="center">ຊື່ສີນຄ່າ</th>
                    <th>ຈໍານວນ</th>
                    <th>ລາຄາ/ກີບ</th>
                </tr>
                <?php
                //print_r(\Yii::$app->session['product']);
                $total_prince = 0;
                $pro_id = [];
                //unset(\Yii::$app->session['product']);
                //unset(\Yii::$app->session['product_id']);
                if (!empty(\Yii::$app->session['product'])) {

                    //  print_r(\Yii::$app->session['product']);exit;
                    foreach (\Yii::$app->session['product'] as $order_p => $quatity) {
                        $product = \app\models\Products::find()->where(['id' => $order_p])->one();
                        ?>
                        <?php
                        if ($product->id == Yii::$app->session->getFlash('su')) {
                            ?>
                            <tr style="background:#b2ebb7">
                            <?php
                        } elseif ($product->id == Yii::$app->session->getFlash('error')) {
                            ?>
                            <tr style="background:#f78c8c">
                            <?php
                        } else {
                            ?>
                            <tr>
                            <?php
                        }
                        ?>
                        <td><?= $product->name ?></td>
                        <td>
                            <div id="qtd<?= $product->id ?>" align="right" style="width:50px;">
                                <?php
                                if ($quatity > 0) {
                                    echo $quatity;
                                }
                                ?>
                            </div>
                        </td>
                        <td align="right"><?= number_format($product->pricesale * $quatity, 2) ?></td>
                        </tr>
                        <?php
                        $total_prince += $product->pricesale * $quatity;
                    }
                }
                ?>
            </table>
        </div>
        <div class="row table-responsive">
            <table class="table table-info">
                <tr>
                    <td colspan="3" align="right"><b><?= Yii::t('app', 'ລວມຈຳນວນເງີນ') ?></b></td>
                    <td align="right">​<b><?= number_format($total_prince, 2) ?> ກີບ</b></td>
                </tr>
                <?php
                if ($total_prince != 0) {
                    ?>
                    <tr>
                        <td colspan="3" align="right"><b><?= Yii::t('app', 'ສ່ວນຫລຸດ') ?></b></td>
                        <td align="right" style="width:100px;" id="dsc">​<b>
                                <?php
                                if (\Yii::$app->session['discount'] == 0) {
                                    \Yii::$app->session['discount'] = 0;
                                }
                                echo number_format(\Yii::$app->session['discount'], 2).' ກີບ';
                                ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><b><?= Yii::t('app', 'ລວມຈໍານວນເງີນຕ້ອງຈ່າຍ') ?></b></td>
                        <td align="right" style="width:100px;" id="dsc"><b>
                                <?php
                                echo number_format($total_prince - \Yii::$app->session['discount'], 2).' ກີບ';
                                ?>
                            </b>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>