<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\alert\Alert;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
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
<div class="payment-index">
    <div class="row">
        <div class="col-md-8 col-xs-8 col-sm-8 ">
            <div class="line_bottom">
                ລາຍ​ການ​ລາຍຈ່າຍ​ຜ່ານ​ມາ
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
            //    'filterModel' => $searchModel,
            'pager' => [
                'maxButtonCount' => 9, // Set maximum number of page buttons that can be displayed
            ],
            'summary' => '',
            'layout' => "{summary}\n{items}\n<div align='center'>{pager}</div>",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'type_pay_id',
                    'header' => 'ປະ​ເພດ​ໃຊ້​ຈ່າຍ',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'value' => function ($data) {
                return $data->typePay->name;
            },
                ],
                [
                    'attribute' => 'amount',
                    'header' => 'ຈຳ​ນວນ​ເງີນ',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'value' => function ($data) {
                return number_format($data->amount, 2);
            },
                ],
                [
                    'attribute' => 'date',
                    'header' => 'ວັນ​ທີ່​ຈ່າຍ',
                    'contentOptions' => ['style' => 'min-width: 100px;']
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-edit"></span>', ['payment/update', 'id' => $model->id], [
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
