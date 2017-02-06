<?php

use lo\widgets\SlimScroll;
?>
<div class="row">
    <div class="col-md-4 col-sm-4">
        <div class="row">
            <div class="col-md-12"  id="output" >
<?= $this->render('order') ?>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-8" style="border-left: 3px green solid; padding-top: 0px;">
        <div class="row">
            <div class="col-md-8 col-sm-8"></div>
            <div class="col-md-4 col-sm-4">
                <?php
                $form = yii\widgets\ActiveForm::begin();
                $search = new \app\models\ProductsSearch;
                echo $form->field($search, 'name')->textInput([
                    'onchange' => '
                $.post( "index.php?r=products/search1&searchtxt="+$(this).val(), function( data ) {
                $( "#output" ).html( data );
                });
                ', 'placeholder' => 'ຄົ້ນ​ຫາ ລະ​ຫັດ​ບາ​ໂຄດ, ຊື່​ສ​ີ້ນ​ຄ່າ', 'id' => 'search'])->label(false);
                yii\widgets\ActiveForm::end();
                ?>
            </div>
        </div>
        <div class="row" >
            <?=
            SlimScroll::widget([
                'options' => [
                    'height' => '500px'
                ]
            ]);
            ?>
            <?php
            foreach ($model as $model) {
                ?>
                <div class="col-md-3 col-sm-3">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="thumbnail img-responsive" />
                            <?php
                            /* echo yii\helpers\Html::a('<img src="' . Yii::$app->urlManager->baseUrl . '/images/thume/' . $model->image . '" class="thumbnail img-responsive" />', '#', [
                              'title' => Yii::t('yii', 'Close'),
                              'onclick' => "
                              $.ajax({
                              type     :'POST',
                              cache    : false,
                              url  : 'index.php?r=products/order&id=" . $model->id . "',
                              success  : function(response) {
                              $('#output').html(response);
                              }
                              });return false;",
                              ]); */
                            ?>
    <?= $model->name ?>
                            <br/>
                            ລາ​ຄາ: <?= number_format($model->pricesale, 2) ?> ກີບ<br/><br/>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
<?= SlimScroll::end(); ?>
        </div>

    </div>

</div>
