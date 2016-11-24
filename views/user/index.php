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
<?php Pjax::begin() ?>
<div class="user-index">
    <div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6 ">
            <div class="line_bottom">
                ລາຍ​ການ​ຜູ້​ເຂົ້​າ​ລະ​ບົບ
            </div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ເພີ່ມຜູ້​ໃຊ້​ລະ​ບົບ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>
    <div class="table-responsive" style="padding-top: 2px;">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //    'filterModel' => $searchModel,
            'summary' => '',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'photo',
                    'header' => 'ຮູບ',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 50px;'],
                    'value' => function ($data) {
                return Html::img(Yii::$app->request->BaseUrl . '/images/thume/' . $data->photo, ['width' => '100px', 'class' => "img-responsive img-rounded"]);
            },
                ],
                [
                    'attribute' => 'first_name',
                    'header' => 'ຊື່',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'value' => function ($data) {
                return $data->first_name;
            },
                ],
                [
                    'attribute' => 'last_name',
                    'header' => 'ນາມ​ສະ​ກຸນ',
                    'contentOptions' => ['style' => 'min-width: 100px;']
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-edit"></span>', ['user/update', 'id' => $model->id], [
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
        <?php Pjax::end(); ?>
