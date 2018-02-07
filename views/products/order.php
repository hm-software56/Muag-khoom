<?php

use yii\helpers\Html;
use yii\web\UrlManager;
?>

<div class="row">
    <?php
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

    if (Yii::$app->session->hasFlash('error')) {
        echo kartik\alert\Alert::widget([
            'type' => kartik\alert\Alert::TYPE_DANGER,
            'title' => Yii::$app->session->getFlash('action'),
            'icon' => 'glyphicon glyphicon-ok-sign',
            'body' => Yii::$app->session->getFlash('error'),
            'showSeparator' => false,
            'delay' => 500
        ]);
    }
    ?>
</div>
<div class="row" style="padding-left: 2px; padding-right: 2px; padding-bottom: 5px;">
    <script>
        function clickAndDisable(link) {
            // disable subsequent clicks
            link.onclick = function (event) {
                event.preventDefault();
            }
        }
    </script>

    <?php
    echo Html::textInput('name', '', [
        'onchange' => '
                $.post( "index.php?r=products/search&searchtxt="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  document.getElementById("search").focus();
                });
            ', 'autofocus' => 'autofocus', 'placeholder' => 'ລະ​ຫັດ​ບາ​ໂຄດ', 'id' => 'search', 'class' => 'form-control']);
    ?>
</div>
<div class="row table-responsive" style="height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
    <table class="table table-striped" >
        <?php
        // print_r(\Yii::$app->session['product']);
        $total_prince = 0;
        $pro_id = [];
        if (!empty(\Yii::$app->session['product'])) {
            foreach (\Yii::$app->session['product'] as $order_p) {
                if (!in_array(key($order_p), $pro_id)) {
                    $pro_id[] = key($order_p);
                    $product = \app\models\Products::find()->where(['id' => key($order_p)])->one();
                    ?>
                    <tr>
                        <td>
                            <?php
                            echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove" style="color: red;"></span>', '#', [
                                'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/orderdelete&id=" . $product->id . "',
                       success  : function(response) {
                           $('#output').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
                            ]);
                            ?>
                        </td>
                        <td><?= $product->name ?></td>
                        <td>
                            <div id="qtd">
                                <?php
                                /*   if ($order_p['qautity'] > 1) {
                                  echo yii\helpers\Html::a($order_p['qautity'], '#', [
                                  'onclick' => "
                                  $.ajax({
                                  type     :'POST',
                                  cache    : false,
                                  url  : 'index.php?r=products/chageqautity&id=" . $product->id . "',
                                  success  : function(response) {
                                  $('#qtd').html(response);
                                  document.getElementById('qtd').focus();
                                  }
                                  });return false;",
                                  ]);
                                  } else { */
                                echo $order_p['qautity'];
                                // }
                                ?>
                            </div>
                        </td>
                        <td align="right"><?= number_format($product->pricesale * $order_p['qautity'], 2) ?></td>
                    </tr>
                    <?php
                    $total_prince+=$product->pricesale * $order_p['qautity'];
                }
            }
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງ​ີນ</b></td>
            <td align="right">​<b><?= number_format($total_prince, 2) ?></b></td>
        </tr>
        <?php
        if ($total_prince != 0) {
            ?>
            <tr>
                <td colspan="3" align="right"><b>ສ່ວນຫລຸດ</b></td>
                <td align="right" id="dsc">​<b>
                        <?php
                        if (\Yii::$app->session['discount'] == 0) {
                            \Yii::$app->session['discount'] = 0;
                        }
                        echo yii\helpers\Html::a(number_format(\Yii::$app->session['discount'], 2), '#', [
                            'onclick' => "
                                  $.ajax({
                                  type     :'POST',
                                  cache    : false,
                                  url  : 'index.php?r=products/discount',
                                  success  : function(response) {
                                  $('#dsc').html(response);
                                  document.getElementById('dsc').focus();
                                  }
                                  });return false;",
                        ]);
                        ?>
                    </b>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<div class="row" style="border-top: 2px green solid; padding-top: 2px;">
    <div class="col-md-6">
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-hand-right"></span> ຈ່າຍ​ເງີນ', '#', [
            'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/pay&totalprice=" . $total_prince . "',
                       success  : function(response) {
                           $('#output').html(response);
                       }
                       });return false;",
            'class' => "btn btn-large bg-green"
        ]);
        ?>
    </div>
    <div class="col-md-6" align="right">
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove-circle"></span> ຍົກ​ເລີກ', '#', [
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
            'class' => "btn btn-large bg-red"
        ]);
        ?>

    </div>
</div>