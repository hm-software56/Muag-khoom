<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('models', 'Currencies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">
<div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6 ">
            <div class="line_bottom">
                <?=Yii::t('models','ສະ​ກຸນ​ເງີນ')?>
            </div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ເພີ່ມສະ​ກຸນ​ເງີນ', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>
    <div class="table-responsive" style="padding-top: 2px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'code:ntext',
            'rate',
            'round_exch',
            [
                'attribute' => 'base_currency',
                'label'=>Yii::t('models','Base Currency'),
                'format' => 'html',
                'contentOptions' => ['style' => 'text-align:center;'],
                'value' => function ($data) {
                    return ($data->base_currency==1)?'<span style="color:green; "><i class="fa fa-check" aria-hidden="true"></i></span>':"";
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a(
                                            '<span class="glyphicon glyphicon-edit"></span>', ['currency/update', 'id' => $model->id], [
                                        'class' => 'btn btn-success btn-xs',
                                            ]
                            );
                        },
                        ],
            ],
        ],
    ]); ?>
    </div>
</div>
