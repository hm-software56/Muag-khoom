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
                <?=Yii::t('app','ກວດ​ແກ້​ຈຳ​ນວນ​ສີນ​ຄ້າ')?>
            </div>
        </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
           
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
                    'attribute' => 'category_id',
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
                    'attribute' => 'image',
                    'label'=>Yii::t('app','Category Name'),
                    'format' => 'html',
                    'value' => function ($data) {
                return $data->category->name;
            },
                ],
                [
                    //'filter' => false,
                    'attribute' => 'name',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'width: 650px;'],
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
            ]
            ]
        );
        ?>
    </div>
</div>
