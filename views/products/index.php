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
<div class="products-index">

    <div class="row">
        <div class="col-md-8 col-xs-8 col-sm-8 ">
            <div class="line_bottom">
                ລາຍ​ການ​ສີ້ນ​ຄ້າ
            </div>
        </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ປ້ອນ​ສີ້​ນຄ້າ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>

    <div class="table-responsive">
        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => "",
            'columns' => [

                'code',
                [
                    'attribute' => 'image',
                    'filter' => false,
                    'label' => 'ຮູບ',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return Html::img(Yii::$app->request->BaseUrl . '/images/thume/' . $data->image, ['width' => '100px', 'class' => "img-responsive img-rounded"]);
            },
                ],
                [
                    'filter' => false,
                    'attribute' => 'name',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return $data->name;
            },
                ],
                [
                    'filter' => false,
                    'attribute' => 'qautity',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return $data->qautity;
            },
                ],
                [
                    'filter' => false,
                    'attribute' => 'pricebuy',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return number_format($data->pricebuy, 2);
            },
                ],
                [
                    'filter' => false,
                    'attribute' => 'pricesale',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return number_format($data->pricesale, 2);
            },
                ],
                // 'image',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-edit"></span>', ['products/update', 'id' => $model->id], [
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
                ]);
                ?>
                <?php Pjax::end(); ?>
    </div>
</div>
