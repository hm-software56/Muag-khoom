<?php

use kartik\money\MaskMoney;

$form = yii\widgets\ActiveForm::begin();
?>
<?php
if (\Yii::$app->session['width_screen'] > Yii::$app->params['width_disable'] and \Yii::$app->session['height_screen'] > Yii::$app->params['height_disable']) ///for PC
{
    ?>
        <div class="row table-responsive" style=" height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
    <?php

} else { /// for mobile
    ?>
        <div class="row table-responsive" style=" height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
    <?php

}
?>
<script>
    function calc()  // function calculation price
    {

       /* var vl = document.getElementById('textpice').value;
        var v3 = (Number(<?= Yii::$app->session['totalprice'] ?>) - Number(vl));
        var v4 = (Number(vl) - (Number(<?= Yii::$app->session['totalprice'] ?>)));
        if (v3 > 0)
        {
            var value = v3;
            var num = value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            document.getElementById('p_y').innerHTML = num + " <?=Yii::$app->session['currency']->name?>";
            document.getElementById('p_d').innerHTML = "0.00" + " <?= Yii::$app->session['currency']->name ?>";

            document.getElementById('sh').style.display = 'none'; // hidden button payment
            document.getElementById('sh_l').style.display = 'block'; //// show button payment
        } else {
            if (isNaN(v3) == false)
            {
                document.getElementById('p_y').innerHTML = "0.00" + " <?= Yii::$app->session['currency']->name ?>";
                var value1 = v4;
                var num1 = value1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                document.getElementById('p_d').innerHTML = num1 + " <?= Yii::$app->session['currency']->name ?>";
                document.getElementById('sh').style.display = 'block'; //// show button payment
                document.getElementById('sh_l').style.display = 'none'; //// hidden button payment
            }
        }*/
    }
</script>
    <table class="table table-striped " >
        <tr>
            <td align="right"><?=Yii::t('app','ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ທັງ​ໝົດ')?>:</td>
            <td><b><?= number_format(Yii::$app->session['totalprice'] + \Yii::$app->session['discount'], 2) ?> <?=Yii::$app->session['currency']->name?></b></td>

        </tr>
        <tr>
            <td align="right"><?=Yii::t('app','ຈ​ຳ​ນວນ​ເງ​ີນ​ສ່ວນຫຼຸດ')?>:</td>
            <td><b style="color:#FF9233"><?= number_format(\Yii::$app->session['discount'], 2) ?> <?=Yii::$app->session['currency']->name?></b></td>

        </tr>
        <tr>
            <td align="right"><?=Yii::t('app','ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ຕ້ອງ​ຈ່າຍ')?>:</td>
            <td><b><?= number_format(Yii::$app->session['totalprice'], 2) ?> <?=Yii::$app->session['currency']->name?></b></td>

        </tr>
        <tr>
            <td align="right" ><?=Yii::t('app','ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ')?>(<?=Yii::t('app','LAK')?>):</td>
            <td>
                <?php
                /// 1. ----have 3 step open  ---- if want to put price disable this line and change onfocus to onkeyup
                if (empty(\Yii::$app->session['payprice']) && is_null(Yii::$app->session['paystill'])) {
                    \Yii::$app->session['payprice']= Yii::$app->session['totalprice'];
                    Yii::$app->session['paystill']=0;
                    \Yii::$app->session['payprice_lak_exh']=Yii::$app->session['totalprice'];
                }
                echo \yii\helpers\Html::textInput('pice_lak', number_format(\Yii::$app->session['payprice'],2), ['autocomplete'=>"off" , 'onfocus' => 'calc()1', 'id' => 'textpice', 'onmouseout' => '
                $.post( "index.php?r=products/pay&pricelak="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  //document.getElementById("textpice").focus();
                });
            ', 'class' => 'form-control input-sm money_format','readonly'=>false
                ]);
                ?> 
            </td>

        </tr>
        <tr>
            <td align="right" ><?=Yii::t('app','ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ')?>(<?=Yii::t('app','TH')?>):</td>
            <td>
                <?php
                /// 1. ----have 3 step open  ---- if want to put price disable this line and change onfocus to onkeyup
               // \Yii::$app->session['payprice']= Yii::$app->session['totalprice']; 
                echo \yii\helpers\Html::textInput('pice_th', number_format(\Yii::$app->session['paypriceth'],2), ['autocomplete'=>"off" , 'onfocus' => 'calc()1', 'id' => 'textpice1', 'onmouseout' => '
                $.post( "index.php?r=products/pay&priceth="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  //document.getElementById("textpice").focus();
                });
            ', 'class' => 'form-control input-sm money_format','readonly'=>false
                ]);
                ?> 
            </td>

        </tr>
        <tr>
            <td align="right" ><?=Yii::t('app','ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ')?>(<?=Yii::t('app','USD')?>):</td>
            <td>
                <?php
                /// 1. ----have 3 step open  ---- if want to put price disable this line and change onfocus to onkeyup
               // \Yii::$app->session['payprice']= Yii::$app->session['totalprice']; 
                echo \yii\helpers\Html::textInput('pice_usd', number_format(\Yii::$app->session['paypriceusd'],2), ['autocomplete'=>"off" , 'onfocus' => 'calc()1', 'id' => 'textpice2', 'onmouseout' => '
                $.post( "index.php?r=products/pay&priceusd="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  //document.getElementById("textpice").focus();
                });
            ', 'class' => 'form-control input-sm money_format','readonly'=>false
                ]);
                ?> 
            </td>

        </tr>
        <tr>
            <td align="right"><?= Yii::t('app', 'ຈ​ຳ​ນວນ​​ເງີນຄ້າງ') ?>:</td>
            <td style="color: red"><b><div id="p_y"><?= number_format(\Yii::$app->session['paystill'], 2) ?> <?= Yii::$app->session['currency']->name?></div></b></td>

        </tr>
        <tr>
            <td align="right"><?= Yii::t('app', 'ຈ​ຳ​ນວນ​​ເງີນຖອນ') ?>:</td>
            <td style="color: green"><b><div id="p_d">
                <?php
                if (\Yii::$app->session['paychange']>0) {
                    $return_pay=\Yii::$app->session['paychange']+(Yii::$app->session['currency']->round_exch);
                }else{
                    $return_pay=\Yii::$app->session['paychange'];
                }
                if(Yii::$app->session['currency']->id==1) /// 1 is id table currency Kip
                {
                    echo  number_format(round($return_pay,-3), 2) ;
                }
                if(Yii::$app->session['currency']->id==2) /// 1 is id table currency USD
                {
                    echo  number_format(round($return_pay,1), 2) ;
                }
                if(Yii::$app->session['currency']->id==3) /// 1 is id table currency Bath
                {
                    echo  number_format((int)round($return_pay,0), 2) ;
                }
                ?>
            <?=Yii::$app->session['currency']->name ?>
            </div></b></td>

        </tr>
    </table>
    <!-- /// 2. if want to put price enable change block to none -->
    <div id="sh1" class="col-md-12" align="right" style="display: <?= (isset(Yii::$app->session['paystill']) && Yii::$app->session['paystill'] == 0) ? "block" : "none" ?>">
        
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-ok-circle"></span> '.Yii::t('app', 'ຢັ້ງ​ຢື້ນ​ຈ່າຍ​ເງີນ'), '#', [
            'onclick' => "
                        $.ajax({
                       type:'POST',
                       cach: false,
                       url: 'index.php?r=products/ordercomfirm',
                       'beforeSend': function(){
                                        $('#send').remove();
                                        document.getElementById('textpice').disabled = true;
                                        document.getElementById('textpice1').disabled = true;
                                        document.getElementById('textpice2').disabled = true;
                                        $('#load').html('<img src=images/loading.gif width=40 />');
                                    },
                        success: function(response) {
                            $('#output').html(response);
                       }
                       });return false;",
            'class' => "btn btn-large bg-green",
            'id' => 'send'
        ]);
        ?>
    </div>
    <!--  ///// 3. if want to put price enable this comment -->
        <div id="sh_l" class="col-md-12" align="right" style="display: <?= (isset(Yii::$app->session['paystill']) && Yii::$app->session['paystill'] == 0) ? "none" : "block" ?>">
        <a href="#" class="btn btn-large bg-yellow"><span class="glyphicon glyphicon-alert"></span> <?= Yii::t('app', 'ຢັ້ງ​ຢື້ນ​ຈ່າຍ​ເງີນ')?></a>
    </div> 
    <div id="load" align='right'></div>
</div>
<?php
yii\widgets\ActiveForm::end();
?>
<div class="row" style="border-top: 2px green solid; padding-top: 2px; padding-bottom: 2px; padding-right: 10px;">
    <div class="col-md-6 col-xs-6">
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-backward"></span> '. Yii::t('app', 'ກັບ​ຄ​ືນ'), '#', [
            'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/search&searchtxt=NULL',
                       'beforeSend': function(){
                            $('#load').html('<img src=images/loading.gif width=40 />');
                        },
                       success  : function(response) {
                           $('#output').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
            'class' => "btn btn-large bg-red"
        ]);
        ?>
    </div>
    <div class="col-md-6 col-xs-6" align="right">
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove-circle"></span> '. Yii::t('app', 'ຍົກ​ເລີກ'), '#', [
            'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/ordercancle',
                       'beforeSend': function(){
                            $('#load').html('<img src=images/loading.gif width=40 />');
                        },
                       success  : function(response) {
                           $('#output').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
            'class' => "btn btn-large bg-blue"
        ]);
        ?>
    </div>
</div>