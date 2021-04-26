<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProductTransfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Transfers'), 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-transfer-view">
    <div class="line_bottom" style="padding-bottom: 10px;">
        <?= Yii::t('app', 'ລາຍລະອຽດສີນຄ້າໂອນໃຫ້ສາຂາ') ?>
        <p style="float: right">
            <?php
            if ($model->status == 0) {
                ?>
                <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> ' . Yii::t('models', 'ແກ້ໄຂ'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-check" aria-hidden="true"></i> ' . Yii::t('models', 'ຢັ້ງຢືນສຳເລັດ'), ['confirm', 'id' => $model->id], ['class' => 'btn btn-success',
                    'data' => [
                        'confirm' => Yii::t('models', '່ທ່ານໄດ້ກວດຂໍ້ມູນສີນຄ້າທີ່ຈະໂອນໃຫ້ສາຂາຖືກຕ້ອງແລ້ວບໍ່.?') . "\n" . Yii::t('models', 'ຖ້າຖືກຕ້ອງແລ້ວກົດ OK ເພື່ອຢັ້ງຢືນສຳເລັດ'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<i class="fa fa-times" aria-hidden="true"></i> ' . Yii::t('models', 'ລືບອອກ'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('models', 'Are you sure you want to delete this transfer?'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?php
            }
            ?>
        </p>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'branch_id',
                'value' => function ($data) {
                    return $data->branch->branch_name;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return \app\models\ProductTransfer::Status($data->status);
                }
            ],
            'date_create',
        ],
    ]) ?>
    <br/>
    <label><?= Yii::t('app', 'ລາຍການສີ້ນຄ້າ') ?></label>
    <table class="table tab-content">
        <tr style="background:#eff5f5">
            <td></td>
            <th><?= Yii::t('app', 'ຊື່ສີນຄ້າ') ?></th>
            <th><?= Yii::t('app', 'ຈຳນວນ') ?></th>
            <th><?= Yii::t('app', 'ລາຄາຊື້/ຕໍ່ໜ່ວຍ') ?></th>
            <th><?= Yii::t('app', 'ລວມເງີນ') ?></th>
        </tr>
        <?php

        $tatol = 0;
        $i = 0;
        foreach ($model->itemTransfers as $item) {
            $i++;
            $tatol += $item->qautity * $item->price_buy;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $item->products->name ?></td>
                <td><?= $item->qautity ?> </td>
                <td><?= number_format($item->price_buy, 2) ?></td>
                <td><?= number_format($item->qautity * $item->price_buy, 2) ?></td>

            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="4" align="right"><b><?= Yii::t('app', 'ລວມເງີນທັງໝົດ') ?></b></td>
            <td colspan="2"><b><?= number_format($tatol, 2) ?></b></td>
        </tr>
    </table>
</div>
