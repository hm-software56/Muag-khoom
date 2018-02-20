<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row" id="qtt" style="font-family: 'Saysettha OT'">

    <div class="col-md-6 col-sm-6">
        <div class="row">
            <div class="col-md-12">
                <b><?= Yii::t('app','ລາຍ​ລະ​ອຽດສີ້ນ​ຄ້າ')?></b>
            </div>
        </div>
        <div class="products-view">
            <?php
            if (Yii::$app->session->hasFlash('suqtt')) {
                echo kartik\alert\Alert::widget([
                    'type' => kartik\alert\Alert::TYPE_SUCCESS,
                    'title' => Yii::$app->session->getFlash('action'),
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'body' => Yii::$app->session->getFlash('suqtt'),
                    'showSeparator' => false,
                    'delay' => 500
                ]);
            }

            if (Yii::$app->session->hasFlash('errorqtt')) {
                echo kartik\alert\Alert::widget([
                    'type' => kartik\alert\Alert::TYPE_DANGER,
                    'title' => Yii::$app->session->getFlash('action'),
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'body' => Yii::$app->session->getFlash('errorqtt'),
                    'showSeparator' => false,
                    'delay' => 2000
                ]);
            }
            ?>
            <table class="table table-striped">
                <tr>
                    <td>ຊື່​ສີ້ນ​ຄ້າ</td>
                    <td>​<?= $model->name ?></td>
                </tr>
                <tr>
                    <td>ຈຳ​ນວນ​ສີ້​ນ​ຄ້າ</td>
                    <td>
                        <div id="qt">
                            <?php
                            echo yii\helpers\Html::a($model->qautity, '#', [
                                'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/qautityupdate&idp=" . $model->id . "&qautity=" . $model->qautity . "',
                       success  : function(response) {
                           $('#qt').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
                                'class' => "btn btn-sm bg-green"
                            ]);
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>​<?= Yii::t('app', 'ລາ​ຄາ​ຊື້')?></td>
                    <td><?= number_format($model->pricebuy, 2) ?> <?= Yii::t('app', 'ກີບ')?></td>
                </tr>
                <tr>
                    <td>​<?= Yii::t('app', 'ລາ​ຄາ​ຂາຍ')?></td>
                    <td><?= number_format($model->pricesale, 2) ?> <?= Yii::t('app', '​ກີບ')?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('app', '​ຮູບ​ພາບ')?></td>
                    <td><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" width="100" class="thumbnail"></td>
                </tr>
            </table>

        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="row">
            <div class="col-md-12">
                <b><?= Yii::t('app', 'ປ້ອນ​ລະ​ຫັດ​ບາ​ໂຄດຂອງ​ສີນ​ຄ້າ')?> <?php // Html::a('<span class="glyphicon glyphicon-barcode"></span>', ['products/gbcode', 'id' => $_GET['id']]) ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="barcode">
                <?= $this->render('barcode', ['models' => $barcode]) ?>
            </div>
        </div>
    </div>
</div>