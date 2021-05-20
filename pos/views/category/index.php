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
                <?= Yii::t('app', 'ປະເພດສີນຄ້າ') ?>
            </div>
        </div>
        <?php
        if (!Yii::$app->user->identity->branch_id) {
            ?>
            <div class="col-md-6 col-xs-6 col-sm-6">
                <p align='right'>
                    <?= Html::a('<span class="fa fa-plus-circle"></span> ' . Yii::t('app', 'ເພີ່ມປະເພດສີນຄ້າ') . '', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                </p>
            </div>
            <?php
        }
        ?>
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
                [
                    //'filter' => false,
                    'attribute' => 'category_id',
                    'label' => Yii::t('models', 'Parent'),
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 250px;'],
                    'value' => function ($data) {
                        if (!empty($data->category_id)) {
                            return $data->category->name;
                        } else {
                            return null;
                        }
                    },
                ],
                //  'date',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{sub} {update} {delete}',
                    'visibleButtons' => [
                        'sub' => function ($model, $key, $index) {
                            return (\Yii::$app->session['user']->user_type == "Admin" && !Yii::$app->user->identity->branch_id) ? true : false;
                        },
                        'update' => function ($model, $key, $index) {
                            return (\Yii::$app->session['user']->user_type == "Admin" && !Yii::$app->user->identity->branch_id) ? true : false;
                        },
                        'delete' => function ($model, $key, $index) {
                            return (\Yii::$app->session['user']->user_type == "Admin" && !Yii::$app->user->identity->branch_id) ? true : false;
                        },
                    ],
                    'buttons' => [
                        'sub' => function ($url, $model) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-plus"></span>', ['category/addsub', 'id' => $model->id], [
                                    'class' => 'btn btn-primary btn-xs',
                                ]
                            );
                        },
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
