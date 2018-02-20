<?php

use kartik\money\MaskMoney;

$form = yii\widgets\ActiveForm::begin();
?>
<div class="row table-responsive" style="height: 450px;">
    <table class="table table-striped " >
        <tr>
            <td align="right"><?=Yii::t('app','ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ທັງ​ໝົດ')?>:</td>
            <td><b><?= number_format(Yii::$app->session['totalprice'] + \Yii::$app->session['discount'], 2) ?> <?=Yii::t('app','ກີບ')?></b></td>

        </tr>
        <tr>
            <td align="right"><?=Yii::t('app','ຈ​ຳ​ນວນ​ເງ​ີນ​ສ່ວນຫຼຸດ')?>:</td>
            <td><b style="color:#FF9233"><?= number_format(\Yii::$app->session['discount'], 2) ?> <?=Yii::t('app','ກີບ')?></b></td>

        </tr>
        <tr>
            <td align="right"><?=Yii::t('app','ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ຕ້ອງ​ຈ່າຍ')?>:</td>
            <td><b><?= number_format(Yii::$app->session['totalprice'], 2) ?> <?=Yii::t('app','ກີບ')?></b></td>

        </tr>
        <tr>
            <td align="right" ><?=Yii::t('app','ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ')?>:</td>
            <td>
                <script>
                    function calc()  // function calculation price
                    {

                        var vl = document.getElementById('textpice').value;
                        var v3 = (Number(<?= Yii::$app->session['totalprice'] ?>) - Number(vl));
                        var v4 = (Number(vl) - (Number(<?= Yii::$app->session['totalprice'] ?>)));
                        if (v3 > 0)
                        {
                            var value = v3;
                            var num = value.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                            document.getElementById('p_y').innerHTML = num + " <?=Yii::t('app','ກີບ')?>";
                            document.getElementById('p_d').innerHTML = "0.00" + " <?= Yii::t('app', 'ກີບ') ?>";

                            document.getElementById('sh').style.display = 'none'; // hidden button payment
                            document.getElementById('sh_l').style.display = 'block'; //// show button payment
                        } else {
                            if (isNaN(v3) == false)
                            {
                                document.getElementById('p_y').innerHTML = "0.00" + " <?= Yii::t('app', 'ກີບ') ?>";
                                var value1 = v4;
                                var num1 = value1.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                                document.getElementById('p_d').innerHTML = num1 + " <?= Yii::t('app', 'ກີບ') ?>";
                                document.getElementById('sh').style.display = 'block'; //// show button payment
                                document.getElementById('sh_l').style.display = 'none'; //// hidden button payment
                            }
                        }
                    }
                </script>
                <?php
                echo \yii\helpers\Html::textInput('pice_txt', \Yii::$app->session['payprice'], ['autocomplete'=>"off" ,'onkeyup' => 'calc()', 'id' => 'textpice', 'onmouseout' => '
                $.post( "index.php?r=products/pay&pricetxt="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                 // document.getElementById("textpice").focus();
                });
            ', 'class' => 'form-control input-sm'
                ]);
                ?>
            </td>

        </tr>
        <tr>
            <td align="right"><?= Yii::t('app', 'ຈ​ຳ​ນວນ​​ເງີນຄ້າງ') ?>:</td>
            <td style="color: red"><b><div id="p_y"><?= number_format(\Yii::$app->session['paystill'], 2) ?> <?= Yii::t('app', 'ກີບ') ?></div></b></td>

        </tr>
        <tr>
            <td align="right"><?= Yii::t('app', 'ຈ​ຳ​ນວນ​​ເງີນຖອນ') ?>:</td>
            <td style="color: green"><b><div id="p_d"><?= number_format(\Yii::$app->session['paychange'], 2) ?> <?= Yii::t('app', 'ກີບ') ?></div></b></td>

        </tr>
    </table>

    <div id="sh" class="col-md-12" align="right" style="display: <?= (isset(Yii::$app->session['paystill']) && Yii::$app->session['paystill'] == 0) ? "block" : "none" ?>">
        <div id="load" align='right'></div>
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-ok-circle"></span> '.Yii::t('app', 'ຢັ້ງ​ຢື້ນ​ຈ່າຍ​ເງີນ'), '#', [
            'onclick' => "
                        $.ajax({
                       type:'POST',
                       cach: false,
                       url: 'index.php?r=products/ordercomfirm',
                       'beforeSend': function(){
                                        $('#send').remove();
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
    <div id="sh_l" class="col-md-12" align="right" style="display: <?= (isset(Yii::$app->session['paystill']) && Yii::$app->session['paystill'] == 0) ? "none" : "block" ?>">
        <a href="#" class="btn btn-large bg-yellow"><span class="glyphicon glyphicon-alert"></span> <?= Yii::t('app', 'ຢັ້ງ​ຢື້ນ​ຈ່າຍ​ເງີນ')?></a>
    </div>
</div>
<?php
yii\widgets\ActiveForm::end();
?>
<div class="row" style="border-top: 2px green solid; padding-top: 2px;">
    <div class="col-md-6">
        <?php
        echo yii\helpers\Html::a('<span class="glyphicon glyphicon-backward"></span> '. Yii::t('app', 'ກັບ​ຄ​ືນ'), '#', [
            'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/search&searchtxt=NULL',
                       success  : function(response) {
                           $('#output').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
            'class' => "btn btn-large bg-red"
        ]);
        ?>
    </div>
    <div class="col-md-6 " align="right">
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
            'class' => "btn btn-large bg-blue"
        ]);
        ?>
    </div>
</div>