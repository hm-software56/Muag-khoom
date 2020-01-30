<?php
use yii\helpers\Html;
use yii\web\UrlManager;

$multi_currency_pay = app\models\PayMultiCurency::find()->where(['invoice_id' => $invoice->id])->one();
?>
<?= $this->render('invoice', ['invoice' => $invoice]); ?>
<?php
if (\Yii::$app->session['width_screen'] > Yii::$app->params['width_disable'] and \Yii::$app->session['height_screen'] > Yii::$app->params['height_disable']) ///for PC
{
    ?>
<div class="row table-responsive" style="overflow-y:auto; height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
    <?php
} else { /// for mobile
    ?>
    <div class="row table-responsive" style="overflow-y:auto; height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
        <?php
    }
    ?>
        <table class="table table-striped">
            <tr>
                <th>ລາຍ​ການ</th>
                <th>ຈຳ​ນວນ</th>
                <th>ລາ​ຄາ</th>
            </tr>
            <?php
            $total_prince = 0;
            $pro_id = [];
            if (!empty(\Yii::$app->session['product'])) {
                foreach (\Yii::$app->session['product'] as $order_p => $qautity) {
                    if (!in_array($order_p, $pro_id)) {
                        $pro_id[] = $order_p;
                        $product = \app\models\Products::find()->where(['id' => $order_p])->one(); ?>
            <tr>
                <td><?= $product->name ?></td>
                <td>
                    <?php
                    echo $qautity; ?>
                </td>
                <td align="right"><?= number_format($product->pricesale * $qautity, 2) ?></td>
            </tr>
            <?php
            $total_prince += $product->pricesale * $qautity;
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
                <td colspan="2" align="right">
                    <?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ') . "(" . Yii::t('app', 'LAK') . ")" ?></td>
                <td align="right">​<b><?= number_format($multi_currency_pay->amount_kip, 2) ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ') . "(" . Yii::t('app', 'TH') . ")" ?></td>
                <td align="right">​<b><?= number_format($multi_currency_pay->amount_th, 2) ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <?= Yii::t('app', '​ຈຳ​ນວນ​ເງ​ີນຈ່າຍ') . "(" . Yii::t('app', 'USD') . ")" ?></td>
                <td align="right">​<b><?= number_format($multi_currency_pay->amount_usd, 2) ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="right">ຈ​ຳ​ນວນ​​ເງີນຖອນ</td>
                <td align="right">​<b>
                        <?php
                        if (\Yii::$app->session['paychange'] > 0) {
                            $return_pay = \Yii::$app->session['paychange'] + (Yii::$app->session['currency']->round_exch);
                        } else {
                            $return_pay = \Yii::$app->session['paychange'];
                        }
                        if (Yii::$app->session['currency']->id == 1) { /// 1 is id table currency Kip
                            echo number_format(round($return_pay, -3), 2);
                        }
                        if (Yii::$app->session['currency']->id == 2) { /// 1 is id table currency USD
                            echo number_format(round($return_pay, 1), 2);
                        }
                        if (Yii::$app->session['currency']->id == 3) { /// 1 is id table currency Bath
                            echo number_format((int)round($return_pay, 0), 2);
                        }
                        ?>
                    </b></td>
            </tr>
        </table>
        <div id="load" align='right'></div>
    </div>

    <div class="row" style="border-top: 2px green solid; padding-top: 2px; padding-bottom: 2px; padding-right: 10px;">
        <div class="col-md-6 col-xs-6">
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
                //'importCSS' => true,
               // 'importStyle' => false,
               // 'loadCSS' => "path/to/my.css",
               // 'pageTitle' => "",
              //  'removeInline' => true,
              //  'printDelay' => 333,
                    'header' => null,
                    'formValues' => true,
                ]
            ]);
            ?>
        </div>
        <div class="col-md-6 col-xs-6 " align="right">
            <?php
            echo yii\helpers\Html::a('ສັ່ງ​ຊື້​ຕໍ່ <span class="glyphicon glyphicon-forward"></span>', '#', [
                'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/sale&cid=',
                       'beforeSend': function(){
                            $('#load').html('<img src=images/loading.gif width=40 />');
                        },
                       success  : function(response) {
                           $('#proct').html(response);
                           document.getElementById('panel').style.display ='block';
                           document.getElementById('search').focus();
                       }
                       });return false;",
                'class' => "btn btn-large bg-green"
            ]);


            ?>
        </div>
        <span id='panel' style="display:none">
            <?php
            echo Html::textInput('name', 'nextorder', [
                'onfocus' => '
                $.post( "index.php?r=products/search&searchtxt="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  document.getElementById("search").focus();
                });
            ', 'autofocus' => 'autofocus', 'id' => 'search', 'style' => "height:0px"
            ]);
            ?>
        </span>
    </div>