<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\alert\Alert;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title=Yii::t("app",'ຈັດ​ການ​ສີນ​ຄ້າ');
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
                <?= Html::a('<span class="fa fa-plus-circle"></span> '. Yii::t('app', 'ປ້ອນ​ສີ້​ນຄ້າ'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>

    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => "",
            'columns' => [

                [
                    'attribute' => 'image',
                    'filter' => false,
                    'label' => Yii::t('app', 'ຮູບ'),
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return Html::img(Yii::$app->request->BaseUrl . '/images/thume/' . $data->image, ['width' => '50px', 'class' => "img-responsive img-rounded"]);
            },
                ],
                [
                    //'filter' => false,
                    'attribute' => 'name',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 250px;'],
                    'value' => function ($data) {
                return $data->name;
            },
                ],
                [
                    'filter' => false,
                    'attribute' => 'qautity',
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:80px;'],
                    'value' => function ($data) {
                        return "<div id=qt".$data->id.">".Html::a($data->qautity, '#', [
                                'onclick' => "
                                $.ajax({
                                type:'POST',
                                cache: false,
                                url:'index.php?r=products/qautityupdateindex&idp=" . $data->id . "&qautity=" . $data->qautity . "',
                                success:function(response) {
                                    $('#qt". $data->id ."').html(response);
                                    document.getElementById('search').focus();
                                }
                                });return false;",
                                        'class' => "btn btn-sm bg-link",
                                ])."</div>";
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
                [
                    'filter' => false,
                    'attribute' => 'user_id',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return $data->user->first_name;
            },
                ],
                // 'image',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'visibleButtons' => [
                        'update' => function ($model, $key, $index) {
                            return (\Yii::$app->session['user']->user_type == "Admin") ? true : false;
                        },
                        'delete' => function ($model, $key, $index) {
                            return (\Yii::$app->session['user']->user_type == "Admin") ? true : false;
                        },
                    ],
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-barcode"></span>', ['products/view', 'id' => $model->id], [
                                            'class' => 'btn bg-blue btn-xs',
                                            ]
                            );
                        },
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
    </div>
</div>
