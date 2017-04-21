<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6 ">
            <div class="line_bottom">
                ປະ​ເພດ​ສີ​ນ​ຄ້າ
            </div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ເພີ່ມປະ​ເພດ​ສີ​ນ​ຄ້າ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>
    <div class="table-responsive" style="padding-top: 2px;">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary' => '',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                //  'date',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-edit"></span>', ['category/update', 'id' => $model->id], [
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
