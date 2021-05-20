<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductTransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product Transfers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-transfer-index">
    <div class="line_bottom" style="padding-bottom: 10px;">
        <?= Yii::t('app', 'ລາຍການໂອນສີນຄ້າ') ?>
        <p style="float: right">
            <?= Html::a('<i class="fa fa-plus-circle" aria-hidden="true"></i> ' . Yii::t('models', 'ໂອນສີ້ນຄ້າ'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'branch_id',
                'label' => Yii::t('app', 'ໂອນໃຫ້ສາຂາ'),
                'value' => function ($data) {
                    return $data->branch->branch_name;
                }
            ],
            [
                'attribute' => 'status',
                'label' => Yii::t('app', 'ສະຖານະການໂອນ'),
                'value' => function ($data) {
                    return \app\models\ProductTransfer::Status($data->status);
                }
            ],
            [
                'attribute' => 'date_create',
                'label' => Yii::t('app', 'ວັນທີ່ໂອນ'),
                'value' => function ($data) {
                    return $data->date_create;
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    'update' => function ($data) {
                        if ($data->status == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'delete' => function ($data) {
                        if ($data->status == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    },
                ],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>', ['product-transfer/view', 'id' => $model->id], [
                                'class' => 'btn btn-primary btn-xs',
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>', ['product-transfer/update', 'id' => $model->id], [
                                'class' => 'btn btn-success btn-xs',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-remove"></span>', $url, [
                                'title' => 'Delete',
                                'data-pjax' => '0',
                                'data-method' => "post",
                                'data-confirm' => Yii::t('app', 'Are you want to delete this item.?'),
                                'class' => 'btn btn-danger btn-xs',
                            ]
                        );
                    },
                ],
                'contentOptions' => ['align' => 'right', 'style' => 'min-width: 75px;white-space:nowrap;'],
            ],
        ],
    ]); ?>


</div>
