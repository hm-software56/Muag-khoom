<?php

use kartik\select2\Select2;

$this->title = Yii::t("app", 'POS');

?>
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <div class="row">
                <div class="col-md-12 col-md-12-mobile" id="output">
                    <?= $this->render('order') ?>
                </div>
            </div>
        </div>

        <div class="col-md-9 col-sm-8 lin_pos_h">
            <div class="row lin_pos">
                <div class="col-md-8 col-sm-8 col-xs-6">
                    <?php
                    $form = yii\widgets\ActiveForm::begin();
                    $search = new \app\models\Category();
                    /* echo $form->field($search, 'id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name'), [
                         'onchange' => '
                     $.post( "index.php?r=products/sale&cid="+$(this).val(), function( data ) {
                     $( "#proct" ).html( data );
                     });
                     ', 'prompt' => Yii::t('app','ຄົ້ນ​ຫາຕາມ​ປະ​ເພດ'), 'id' => 'search'])->label(false);*/

                    echo $form->field($search, 'id')->widget(Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(\app\models\Category::getList(), 'id', 'name'),
                        'options' => [
                            'placeholder' => Yii::t('app', 'ຄົ້ນ​ຫາຕາມ​ປະ​ເພດ'),
                            'onchange' => '
                        $.post( "index.php?r=products/sale&cid="+$(this).val(), function( data ) {
                        $( "#proct" ).html( data );
                        });',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(false);
                    yii\widgets\ActiveForm::end();
                    ?>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-search"></i>
                        <?php
                        $form = yii\widgets\ActiveForm::begin();
                        $search = new \app\models\ProductsSearch;
                        echo $form->field($search, 'name')->textInput([
                            'oninput' => '
                        $.post( "index.php?r=products/searchpd&searchtxt="+$(this).val(), function( data ) {
                        $( "#proct" ).html( data );
                        });
                ', 'placeholder' => Yii::t('app', 'ຄົ້ນ​ຫາ'), 'autocomplete' => "off", 'id' => 'search11'
                        ])->label(false);
                        yii\widgets\ActiveForm::end();

                        ?>
                    </div>
                </div>
            </div>
            <div class="row" id="proct">
                <?= $this->render('pos_pro', ['model' => $model]) ?>
            </div>

        </div>

    </div>
<?php
if (Yii::$app->params['enable_display_client_pos'] == true) {
    ?>
    <script type="text/javascript">
        window.onload = function () {
            window.open('<?=Yii::$app->params['url_display_client_pos']?>', 'new games release', ' menubar=0, resizable=0,dependent=0,status=0,width=700,height=300,left=30,top=50')
        }
    </script>
    <?php
}
?>