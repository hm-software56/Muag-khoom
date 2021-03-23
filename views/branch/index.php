<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Branches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-index">
    <div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6 ">
            <div class="line_bottom">
                <?= Yii::t('app', 'ສາຂາ') ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ' . Yii::t('app', 'ເພີ່ມສາຂາ') . '', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'branch_name',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    if ($data->status == 1) {
                        return Yii::t('app', 'ເປິດ');
                    }else{
                        return Yii::t('app', 'ປິດ');
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>', ['branch/update', 'id' => $model->id], [
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
                'contentOptions' => ['align' => 'right', 'style' => 'min-width: 75px'],
            ],
        ],
    ]); ?>


</div>
