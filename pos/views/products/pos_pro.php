<?php

use lo\widgets\SlimScroll;

?>
<?php
if (\Yii::$app->session['width_screen'] > Yii::$app->params['width_disable'] and \Yii::$app->session['height_screen'] > Yii::$app->params['height_disable']) ///for PC
{
    echo SlimScroll::widget([
        'options' => [
            'height' => \Yii::$app->session['height_screen'] . 'px',

            // 'alwaysVisible' => true,
            // "distance" => '20px',
            "wheelStep" => 100,
        ]
    ]);
} else {
    ?>
    <div class="row table-responsive" style=" overflow-y:auto; height:<?= \Yii::$app->session['height_screen'] - 30 . 'px' ?>;">
    <?php
}
?>
    <style>
        /* display this row with flex and use wrap (= respect columns' widths) */
        .row-flex {
            display: flex;
            flex-wrap: wrap;
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>

    <div class="row row-flex">
        <?php
        foreach ($model as $model) {
            ?>
            <div class="col-md-2 col-sm-3 col-xs-6 ">
                <div class="row">
                    <div class="col-md-12 " align="center">
                        <div class="col-md-12 aa">
                            <span style='background:#003300; padding-left:5px; padding-right:5px;border-radius:2px;'>
                                <?php
                                if (Yii::$app->user->identity->branch_id) {
                                    $qtt = \app\models\Warehousebranch::find()->where(['products_id' => $model->id])->one();
                                    echo $qtt->qautity;
                                } else {
                                    echo $model->qautity;
                                }
                                ?>
                            </span>
                        </div>
                        <!-- <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="thumbnail img-responsive" />-->
                        <?php
                        if (empty($model->image)) {
                            $model->image = 'default.png';
                        }
                        $img = \toriphes\lazyload\LazyLoad::widget(['options' => ['class' => "thumbnail img-responsive"], 'src' => '' . Yii::$app->urlManager->baseUrl . "/images/thume/" . $model->image . '', 'fallback' => true]);
                        #$img='<img src="' . Yii::$app->urlManager->baseUrl . '/images/thume/' . $model->image . '" class="thumbnail img-responsive" />';
                        echo yii\helpers\Html::a($img, '#', [
                            'title' => Yii::t('yii', 'ຂາຍ'),
                            'onclick' => "
                  $.ajax({
                  type     :'POST',
                  cache    : false,
                  url  : 'index.php?r=products/order&id=" . $model->id . "',
                  'beforeSend': function(){
                        $('#send').remove();
                        $('#load').html('<img src=images/loading.gif width=40 />');
                    },
                  success  : function(response) {
                  $('#output').html(response);
                   document.getElementById('search').focus();
                  }
                  });return false;",
                        ]);
                        ?>
                        <?= $model->name ?>
                        <br/>
                        <span class="text-red"><?= number_format($model->pricesale, 2) ?></span> <?= Yii::$app->session['currency']->name ?>
                        <br/><br/>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
    </div>
<?php

if (\Yii::$app->session['width_screen'] > Yii::$app->params['width_disable'] and \Yii::$app->session['height_screen'] > Yii::$app->params['height_disable']) ///for PC
{
    echo SlimScroll::end();
} else {
    echo "</div>";
}
?>