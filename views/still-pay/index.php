<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StillPaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Still Pays');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="still-pay-index">

    <div class="row">
        <div class="col-md-8 col-xs-8 col-sm-8 ">
            <div class="line_bottom">
                ລາຍ​ການ​ໜິ​ຄ້າງ
            </div>
        </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
            <p align='right'>
                <?= Html::a('<span class="fa fa-plus-circle"></span> ' . Yii::t('app', 'ປ້ອນ​ໜິ​ຄ້າງ'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'summary' => "",
        'columns' => [
            [
                'filter' => false,
                'attribute' => 'details',
                'format' => 'html',
                'value' => function ($data) {
                    return \app\models\StillPay::details($data->id);
                },
            ],
            
           // 'date',
            //'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class=" fa fa-thumbs-up"></span> ຈ່າຍ',
                            ['still-pay/paid', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'onclick' => "onclick_loadimg()",
                            ]
                        );
                    },
                ],
                'contentOptions' => ['align' => 'right', 'style' => 'width: 5px'],
            ],
        ],
    ]); ?>
</div>
