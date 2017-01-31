<?php

use yii\bootstrap\Modal;

if (Yii::$app->session->hasFlash('su')) {
    echo \kartik\alert\Alert::widget([
        'type' => \kartik\alert\Alert::TYPE_SUCCESS,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('su'),
        'showSeparator' => false,
        'delay' => 2000
    ]);
}
?>
<?php
Modal::begin(['clientOptions' => ['keyboard' => false], 'options' => ['id' => 'detail-modal',]])
?>
<div id='modalContent'></div>
<?php yii\bootstrap\Modal::end() ?>
<div class="row">
    <?php
    foreach ($model as $model) {
        ?>
        <div class="col-md-4 col-xs-12">
            <div class="col-xs-6">
                <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="thumbnail img-responsive" />
            </div>
            <div class="col-xs-6">
                ລະ​ຫັດ: <?= $model->code ?>
                <br/>
                ຊື່: <?= $model->name ?>
                <br/>
                ຈຳ​ນວນ: <span class="text-red"><b><?= $model->qautity ?></b></span><br/>
                ລາ​ຄາ: <?= number_format($model->pricesale, 2) ?><br/>
                <?php
                if ($model->qautity != 0) {
                    echo yii\helpers\Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> ສັ່ງຊື້', '#', [
                        'title' => 'View Detail',
                        'onclick' => "$('#detail-modal').modal('show');
                                    $.ajax({
                                       type: 'GET',
                                       cache: false,
                                       url: '" . Yii::$app->urlManager->createUrl(['products/order', 'id' => $model->id]) . "',
                                                success: function(response) {
                                                      $('#detail-modal .modal-body').html(response);
                                                },
                                            });
                                            return false;
                                          ",
                        'class' => 'btn bg-red btn-sm',
                    ]);
                    echo"<br/>";
                    echo"<br/>";
                } else {
                    echo yii\helpers\Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> ສັ່ງຊື້', '#', [
                        'title' => 'View Detail',
                        'class' => 'btn bg-success btn-sm',
                    ]);
                    echo"<br/>";
                    echo"<br/>";
                }
                ?>
            </div>
        </div>
        <?php
    }
    ?>

</div>
