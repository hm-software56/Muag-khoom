<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Purchase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'ຈັດ​ຊື້'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-view">
    <div class="line_bottom">​ສີນ​ຄ້າທີ່​ຊື້</div>
    <?php
    if ($model->status != "confirm") {
        ?>
        <p>
            <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> ' . Yii::t('models', 'ແກ້​ໄຂ'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i> ' . Yii::t('models', 'ຢັ້ງ​ຢືນ​ສຳ​ເລັດ'), ['confirm', 'id' => $model->id], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => Yii::t('models', '່​ທ່ານ​ໄດ້​ກວດຂໍ້​ມູນສີນຄ້າ​ຈັດ​ຊື້​ທັງ​ໝົດ​ທີ່​ທ່ານ​ປ້ອນ​ຖືກ​ຕ້ອງ​ແລ້ວ​​ບໍ່.?') . "\n" . Yii::t('models', '​ຖ້າ​ຖືກ​ຕ້ອງ​ແລ້ວ​ກົດ OK ​ເພື່ອຢັ້ງ​ຢືນ​​ສຳ​ເລັດ'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('<i class="fa fa-times" aria-hidden="true"></i> ' . Yii::t('models', 'ລືບ​ອອກ'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('models', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <?php
    }
    ?>
    <table class="table table-bordered">
        <tr>
            <td style="width:150px;"><b><?= Yii::t('app', '​ວັນ​ທີ່') ?></b></td>
            <td><?= date('Y-m-d', strtotime($model->date)) ?></td>
        </tr>
        <tr>
            <td><b><?= Yii::t('app', 'ລາ​ຍ​ລະ​ອຽດ') ?></b></td>
            <td><?= $model->detail ?></td>
        </tr>
        <tr>
            <td><b><?= Yii::t('app', '​ສະ​ກຸນ​ເງີນ') ?></b></td>
            <td><?= $model->currency->name ?></td>
        </tr>
    </table>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="contacts table-responsive">
            <label><?= Yii::t('app', 'ລາຍ​ການສີ້ນ​ຄ້າ') ?></label>
            <table class="table tab-content">
                <tr style="background:#eff5f5">
                    <td></td>
                    <th><?= Yii::t('app', 'ຊື່​ສີນ​ຄ້າ') ?></th>
                    <td align="right"><b><?= Yii::t('app', 'ຈຳ​ນວນ') ?><b></td>
                    <td align="right"><b><?= Yii::t('app', '​ລາ​ຄາ​ຕໍ່​ໜ່ວຍ') ?></b></td>
                    <td align="right"><b><?= Yii::t('app', 'ລວມ​ເງີນ') ?><b></td>
                </tr>
                <?php
                if (!empty($model_items)) {
                    $i = 0;
                    $tatol = 0;
                    $count = count($model_items);
                    foreach ($model_items as $key => $model_item) {
                        $i++;
                        $count--;
                        $tatol += $model_item->qautity * $model_item->pricebuy;
                        ?>
                        <tr id="list_pt<?= $key ?>">
                            <td><?= $i ?></td>
                            <td><?= $model_item->products->name ?></td>
                            <td align="right"><?= $model_item->qautity + $model_item->qtt_saled ?> </td>
                            <td align="right">
                                <?php
                                if (Yii::$app->session['user']->user_type == "Admin") {
                                    if ($model_item->id) {
                                        echo "<div id=qt" . $model_item->id . ">" . Html::a(number_format($model_item->pricebuy, 2), '#', [
                                                'onclick' => "
                                $.ajax({
                                type:'POST',
                                cache: false,
                                url:'index.php?r=purchase/pricebuy&id=" . $model_item->id . "&pricebuy=" . $model_item->pricebuy . "',
                                success:function(response) {
                                    $('#qt" . $model_item->id . "').html(response);
                                    document.getElementById('search').focus();
                                }
                                });return false;",
                                                'class' => "btn btn-sm bg-link",
                                            ]) . " " . $model->currency->name . "</div>";
                                    }
                                } else {
                                    echo number_format($model_item->pricebuy, 2) . " " . $model->currency->name;
                                }
                                ?>
                            </td>
                            <td align="right"><?= number_format(($model_item->qautity + $model_item->qtt_saled) * $model_item->pricebuy, 2) ?> <?= $model->currency->name ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="4" align="right"><b><?= Yii::t('app', 'ລວມ​ເງີນ​ທັງ​ໝົດ') ?></b></td>
                    <td align="right"><b><?= number_format($tatol, 2) ?> <?= $model->currency->name ?></b></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
