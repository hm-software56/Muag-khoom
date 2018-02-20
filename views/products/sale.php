<?php
    $this->title=Yii::t("app",'POS');
?>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="row">
            <div class="col-md-12"  id="output" >
                <?= $this->render('order') ?>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-sm-8 lin_pos_h">
        <div class="row lin_pos">
            <div class="col-md-8 col-sm-8">
                <?php
                $form = yii\widgets\ActiveForm::begin();
                $search = new \app\models\Category();
                echo $form->field($search, 'id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name'), [
                    'onchange' => '
                $.post( "index.php?r=products/sale&cid="+$(this).val(), function( data ) {
                $( "#proct" ).html( data );
                });
                ', 'prompt' => '', 'id' => 'search'])->label(false);
                yii\widgets\ActiveForm::end();
                ?>
            </div>
            <div class="col-md-4 col-sm-4">
                <?php
                $form = yii\widgets\ActiveForm::begin();
                $search = new \app\models\ProductsSearch;
                echo $form->field($search, 'name')->textInput([
                    'oninput' => '
                $.post( "index.php?r=products/searchpd&searchtxt="+$(this).val(), function( data ) {
                $( "#proct" ).html( data );
                });
                ', 'placeholder' => Yii::t('app', 'ຄົ້ນ​ຫາ ລະ​ຫັດ​ບາ​ໂຄດ, ຊື່​ສ​ີ້ນ​ຄ່າ'), 'id' => 'search'])->label(false);
                yii\widgets\ActiveForm::end();
                ?>
            </div>
        </div>
        <div class="row" id="proct" >
            <?= $this->render('pos_pro', ['model' => $model]) ?>
        </div>

    </div>

</div>
