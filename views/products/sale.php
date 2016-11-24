<?php

use yii\bootstrap\Modal;
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
        <div class="col-md-2 col-xs-6">
            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="thumbnail img-responsive" />
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
        <?php
    }
    ?>

</div>
