<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\alert\Alert;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DaoCarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dao Cars';
if (Yii::$app->session->hasFlash('su')) {
    echo Alert::widget([
        'type' => Alert::TYPE_SUCCESS,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('su'),
        'showSeparator' => false,
        'delay' => 2000
    ]);
}
?>
<div class="dao-car-index">
    <div class="row">
        <div class="col-md-8 col-xs-8 col-sm-8 ">
            <div class="line_bottom">
                ລາຍ​ການ​ຄ່າ​ລົດ​ໃຫຍ່
            </div>
        </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ປ້ອນ​ລາຍ​ຈ່າຍ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>
    <div class="table-responsive" style="padding-top: 2px;">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => '',
            'pager' => [
                'maxButtonCount' => 9, // Set maximum number of page buttons that can be displayed
            ],
            'summary' => '',
            'layout' => "{summary}\n{items}\n<div align='center'>{pager}</div>",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'amount',
                    'format' => 'html',
                    'filter' => false,
                    //  'contentOptions' => ['style' => 'min-width: 100px;'],
                    'value' => function ($data) {
                        return number_format($data->amount, 2);
                    },
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'filter' => false,
                    //  'contentOptions' => ['style' => 'min-width: 100px;'],
                    'value' => function ($data) {
                        return ($data->status == "Paid") ? 'ຈ່າຍ​ແລ​້ວ' : ($data->status == "Saving") ? "ເກັບ​ໄວ້" : "ເອົ​າ​ໄປ​ເຮັດ​ແນວ​ອຶ່ນ";
                    },
                ],
                [
                    'attribute' => 'date',
                    'format' => 'html',
                    'filter' => \yii\jui\DatePicker::widget(['language' => 'en',
                        'dateFormat' => 'yyyy-MM-dd',
                        'model' => $searchModel,
                        'attribute' => 'date',
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                            'showButtonPanel' => true,
                            'dateFormat' => 'yyyy',
                            'yearRange' => '1960:' . date('Y') . ''
                        ],
                    ]),
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'value' => function ($data) {
                return $data->date;
            },
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-edit"></span>', ['dao-car/update', 'id' => $model->id], [
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
                                        'data-confirm' => Yii::t('app', 'ທ່ານ​ຕ້ອງ​ການ​ຈະ​ລືບ​ລາຍ​ຈ່າຍ​ແຖວນີ້​ແທ້​ບໍ.?'),
                                        'class' => 'btn btn-danger btn-xs',
                                            ]
                            );
                        },
                            ],
                            'contentOptions' => ['align' => 'right', 'style' => 'min-width: 75px'],
                        ],
                    ],
                ]);
                ?>
    </div>
</div>
