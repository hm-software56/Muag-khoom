<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models', 'ຈັດ​ຊື້');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-index">
<?php Pjax::begin(); ?>
<div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6 ">
            <div class="line_bottom">
                <?=Yii::t('app','ຈ​ັດ​ຊືື້​ສີນ​ຄ້າ')?>
            </div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ​ຊືື້​ສີນ​ຄ້າ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>
    <div class="table-responsive" style="padding-top: 2px;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'detail:ntext',
                [
                    'attribute' => 'date',
                    'label'=>Yii::t('models','ວັນ​ທີ່'),
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 250px;white-space:nowrap;'],
                    'value' => function ($data) {
                        return date('Y-m-d',strtotime($data->date));
                    },
                ],
                [
                    'attribute' => 'date',
                    'label'=>Yii::t('models','ສະ​ກຸນ​ເງີນ'),
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 250px;'],
                    'value' => function ($data) {
                        return $data->currency->name;
                    },
                ],
                [
                    'attribute' => 'status',
                    'label'=>Yii::t('models','ສະ​ຖາ​ນະ'),
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 250px;'],
                    'value' => function ($data) {
                        return ($data->status=="confirm")?"".Yii::t('app','ສຳ​ເລັດ')."":"".Yii::t('app','ຍັງ​ບໍ່​ສຳ​ເລັດ')."";
                    },
                ],

                ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'visibleButtons' =>[
                        'update' => function ($data) {
                            if($data->status=="confirm")
                            {
                                return false;
                            }else{
                                return true;
                            }
                        },
                        'delete' => function ($data) {
                            if($data->status=="confirm")
                            {
                                return false;
                            }else{
                                return true;
                            }
                        },
                ],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-eye-open"></span>', ['purchase/view', 'id' => $model->id], [
                                    'class' => 'btn btn-primary btn-xs',
                                        ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-edit"></span>', ['purchase/update', 'id' => $model->id], [
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
    <?php Pjax::end(); ?>
</div>
