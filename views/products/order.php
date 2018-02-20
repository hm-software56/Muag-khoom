<?php

use yii\helpers\Html;
use yii\web\UrlManager;
?>

<div class=" row errors" align="right" style="width:100%">
    <?php
    if (Yii::$app->session->hasFlash('success')) {
        echo kartik\alert\Alert::widget([
            'type' => kartik\alert\Alert::TYPE_SUCCESS,
            'title' => Yii::$app->session->getFlash('action'),
            'icon' => 'glyphicon glyphicon-ok-sign',
            'body' => Yii::$app->session->getFlash('success'),
            'showSeparator' => false,
            'delay' => 500
        ]);
    }

    if (Yii::$app->session->hasFlash('errors')) {
        echo kartik\alert\Alert::widget([
            'type' => kartik\alert\Alert::TYPE_DANGER,
            'title' => Yii::$app->session->getFlash('action'),
            'icon' => 'glyphicon glyphicon-alert',
            'body' => Yii::$app->session->getFlash('errors'),
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
            ', 'autofocus' => 'autofocus', 'placeholder' => Yii::t('app', 'ລະ​ຫັດ​ບາ​ໂຄດ'), 'id' => 'search', 'class' => 'form-control']);
    ?>
</div>
<div class="row table-responsive" style="height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
    <table class="table table-striped" >
        <?php
        // print_r(\Yii::$app->session['product']);
        $total_prince = 0;
        $pro_id = [];
        //unset(\Yii::$app->session['product']);
        //unset(\Yii::$app->session['product_id']);
        if (!empty(\Yii::$app->session['product'])) {
            
          //  print_r(\Yii::$app->session['product']);exit;
            foreach (\Yii::$app->session['product'] as $order_p=>$quatity) {
                    $product = \app\models\Products::find()->where(['id' =>$order_p])->one();
                    ?>
                    <?php
                    if($product->id==Yii::$app->session->getFlash('su'))
                    {
                        ?>
                        <tr style="background:#b2ebb7">
                    <?php
                    } elseif($product->id==Yii::$app->session->getFlash('error'))
                    {
                        ?>
                        <tr style="background:#f78c8c">
                    <?php
                    }else{
                        ?>
                        <tr>
                        <?php
                    }
                    ?>
                    
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
                            <div id="qtd<?=$product->id?>" align="right" style="width:50px;">
                                <?php
                                   if ($quatity>0) {
                                  echo yii\helpers\Html::a($quatity, '#', [
                                  'class'=>'btn btn-link',
                                  'onclick' => "
                                  $.ajax({
                                  type     :'POST',
                                  cache    : false,
                                  url  : 'index.php?r=products/chageqautity&id=" . $product->id . "&qautity_old=".$quatity."',
                                  success  : function(response) {
                                  $('#qtd".$product->id."').html(response);
                                  document.getElementById('qtdf".$product->id."').focus();
                                  }
                                  });return false;",
                                ]);
                                  }
                                ?>
                            </div>
                        </td>
                        <td align="right"><?= number_format($product->pricesale * $quatity, 2) ?></td>
                    </tr>
                    <?php
                    $total_prince+=$product->pricesale * $quatity;
                }
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b><?=Yii::t('app','ລວມ​ຈຳ​ນວນ​ເງ​ີນ')?></b></td>
            <td align="right">​<b><?= number_format($total_prince, 2) ?></b></td>
        </tr>
        <?php
        if ($total_prince != 0) {
            ?>
            <tr>
                <td colspan="3" align="right"><b><?=Yii::t('app','ສ່ວນຫລຸດ')?></b></td>
                <td align="right" style="width:100px;" id="dsc">​<b>
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

<div class="row lin_pos_b" >
    <div class="col-md-6">
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-hand-right"></span> '. Yii::t('app', 'ຈ່າຍ​ເງີນ'), '#', [
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
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove-circle"></span> '. Yii::t('app', 'ຍົກ​ເລີກ'), '#', [
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