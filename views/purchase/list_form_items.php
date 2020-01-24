<?php
use kartik\select2\Select2;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-12">
        <div class="contacts table-responsive">
            <label><?=Yii::t('app','ລາຍ​ການສີ້ນ​ຄ້າ')?></label>
            <table class="table table-light">
                <tbody>
                <tr>
                    <td>
                    <label class="control-label" for="purchase-currency_id"><?=Yii::t('app','ສີນ​ຄ້າ')?></label>
                    <?php
                        echo Select2::widget([
                            'name' =>"PurchaseItem['product_id'][]",
                            'id'=>'pro_id',
                            'data' => $product_arr,
                            'options' => [
                                'placeholder' =>Yii::t('app','​ເລືອກ​ສີ້ນ​ຄ້າ....'),
                                'multiple' => false,
                                'autocomplete'=>"off"
                            ],
                        ]);
                    ?>
                    </td>
                    <td>
                        <label class="control-label" for="purchase-currency_id"><?=Yii::t('app','ຈຳ​ນວນ')?></label>
                        <input data-rule-required=true data-msg-required="Your message"  type="text" name="PurchaseItem['qauntity'][]" id="qtt" class="form-control money_format" data-v-min="0" data-v-max="999999" autocomplete="off">
                    </td>
                    <td>
                        <label class="control-label" for="purchase-currency_id"><?=Yii::t('app','ລາ​ຄາ​ຕໍ່​ໜ່ວຍ')?></label>
                         <input type="text" id="price" class="form-control money_format" name="PurchaseItem['price'][]" autocomplete="off">
                    </td>
                    <td>
                    </td>
                    <td>
                        <br/>
                        <?php
                        echo yii\helpers\Html::a("+", '#', [
                            'onclick' => "
                                    $.ajax({
                                    type     :'POST',
                                    cache    : false,
                                    url  : 'index.php?r=purchase/addpurchaseitems',
                                    data: {
                                        product_id: $('#pro_id').val(),
                                        qauntity: $('#qtt').val(),
                                        price: $('#price').val(),
                                    },
                                    success  : function(response) {
                                    $('#list_pt').html(response);
                                    }
                                    });return false;",
                           /// 'style' => "color:red;",
                            'class'=>'btn btn-success btn-sm'
                        ]);
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table tab-content">
                <tr style="background:#eff5f5">
                    <td></td>
                    <th><?=Yii::t('app','ຊື່​ສີນ​ຄ້າ')?></th>
                    <th><?=Yii::t('app','ຈຳ​ນວນ')?></th>
                    <th><?=Yii::t('app','​ລາ​ຄາ​ຕໍ່​ໜ່ວຍ')?></th>
                    <th><?=Yii::t('app','ລວມ​ເງີນ')?></th>
                    <th></th>
                </tr>
                <?php if(Yii::$app->session->hasFlash('success')):?>
                <tr>
                    <td></td>
                    <td colspan="5">
                            <div>
                               <span class="text-red" > <?php echo Yii::$app->session->getFlash('success'); ?></span>
                            </div>
                    </td>
                </tr>
                <?php endif; ?>

                <?php
                
                    $tatol=0;
                    if (!empty(Yii::$app->session['model_items'])) {
                        $i=0;
                        $count=count(Yii::$app->session['model_items']);
                        foreach (Yii::$app->session['model_items'] as $key=>$model) {
                            $i++;
                            $count--;
                            $tatol+=$model->qautity*$model->pricebuy;
                            ?>
                <tr id="list_pt<?=$key?>">
                    <td><?=$count+1?></td>
                    <td><?=$model->products->name ?></td>
                    <td><?=$model->qautity?> </td>
                    <td><?=number_format($model->pricebuy,2)?> </td>
                    <td><?=number_format($model->qautity*$model->pricebuy,2)?></td>
                    <td align="right">
                        <?php
                        echo yii\helpers\Html::a("-", '#', [
                          //  'confirm' => Yii::t('models', 'Are you sure you want to delete this item?'),
                            'onclick' => "
                                if (confirm('".Yii::t('app','ທ່ານ​ຕ້ອງ​ການ​ລຶບ​ລາຍ​ການນີ້ບໍ່.?')."')) {
                                        $.ajax({
                                        type     :'POST',
                                        cache    : false,
                                        url  : 'index.php?r=purchase/delpurchaseitems',
                                        data: {
                                            key_array:".$key.",
                                            id:'".$model->id."',
                                            
                                        },
                                        success  : function(response) {
                                        $('#list_pt".$key."').html(response);
                                        }
                                        });return false;
                                }",
                           // 'style' => "color:red;",
                            'class'=>'btn btn-danger btn-sm'
                        ]); ?>
                    </td>
                </tr>
                <?php
                        }
                    }
                ?>
                <tr>
                    <td colspan="4" align="right"><b><?=Yii::t('app','ລວມ​ເງີນ​ທັງ​ໝົດ')?></b></td>
                    <td colspan="2"><b><?=number_format($tatol,2)?></b></td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
