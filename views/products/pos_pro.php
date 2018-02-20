<?php

use lo\widgets\SlimScroll;
?>
<?=
SlimScroll::widget([
    'options' => [
        'height' => \Yii::$app->session['height_screen'] . 'px',
        // 'alwaysVisible' => true,
        // "distance" => '20px',
        "wheelStep" => 100,
    ]
]);
?>
<?php
foreach ($model as $model) {
    ?>
    <div class="col-md-2 col-sm-3">
        <div class="row">
            <div class="col-md-12" align="center">
            <div class="col-md-12 aa"><?= $model->qautity ?></div>
               <!-- <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="thumbnail img-responsive" />-->
                <?php
                echo yii\helpers\Html::a('<img src="' . Yii::$app->urlManager->baseUrl . '/images/thume/' . $model->image . '" class="thumbnail img-responsive" />', '#', [
                    'title' => Yii::t('yii', 'ຂາຍ'),
                    'onclick' => "
                  $.ajax({
                  type     :'POST',
                  cache    : false,
                  url  : 'index.php?r=products/order&id=" . $model->id . "',
                  success  : function(response) {
                  $('#output').html(response);
                   document.getElementById('search').focus();
                  }
                  });return false;",
                ]);
                ?>
                <?= $model->name ?>
                <br/>
                <span class="text-red"><?= number_format($model->pricesale, 2) ?></span> <?= Yii::t('app','ກີບ')?><br/><br/>
            </div>
        </div>
    </div>
    <?php
}
?>
<?= SlimScroll::end(); ?>