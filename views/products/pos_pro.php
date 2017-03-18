<?php

use lo\widgets\SlimScroll;
?>
<?=
SlimScroll::widget([
    'options' => [
        'height' => \Yii::$app->session['height_screen'] . 'px',
    ]
]);
?>
<?php
foreach ($model as $model) {
    ?>
    <div class="col-md-2 col-sm-3">
        <div class="row">
            <div class="col-md-12" align="center">
               <!-- <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="thumbnail img-responsive" />-->
                <?php
                echo yii\helpers\Html::a('<img src="' . Yii::$app->urlManager->baseUrl . '/images/thume/' . $model->image . '" class="thumbnail img-responsive" />', '#', [
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
                ]);
                ?>
                <?= $model->name ?>
                <br/>
                <span class="text-red"><?= number_format($model->pricesale, 2) ?></span> ກີບ<br/><br/>
            </div>
        </div>
    </div>
    <?php
}
?>
<?= SlimScroll::end(); ?>