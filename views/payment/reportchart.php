<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

\yii\bootstrap\ActiveForm::begin();
?>
<div class="row">
    <div class="col-md-6 col-xs-8">
        <?=
        yii\jui\DatePicker::widget([
            'name' => 'date',
            'value' => isset($_POST['date']) ? $_POST['date'] : "",
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'showButtonPanel' => true,
                'dateFormat' => 'yyyy',
                'yearRange' => '2015:' . date('Y') . '',
            ],
            'options' => ['class' => 'form-control input-sm', 'placeholder' => 'ເລືອກ​ ເດືອນ​ ປີ​']
        ]);
        ?>
    </div>
    <div class="col-md-2 col-xs-2">
        <button type="submit" class="btn bg-aqua btn-sm" ><span class="fa fa-search"></span> ຄົ້ນ​ຫາ</button>
    </div>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>
<?php
if (isset($_POST['date']) && !empty($_POST['date'])) {
    $p_month = date('m', strtotime($_POST['date']));
    $p_year = date('Y', strtotime($_POST['date']));
} else {
    $p_month = date('m');
    $p_year = date('Y');
}
$month = [];
$data = [];
$pay_type = app\models\TypePay::find()->all();
if (Yii::$app->session['user']->user_type == "Admin") {
    $p_all = (int) Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . $p_month . '" and year(payment.date)="' . $p_year . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
} else {
    $p_all = (int) Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . $p_month . '" and year(payment.date)="' . $p_year . '" and user.id=' . Yii::$app->session['user']->id . '')->queryScalar();
}
foreach ($pay_type as $pay_type) {

    if (Yii::$app->session['user']->user_type == "Admin") {
        $p = (int) Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . $p_month . '" and year(payment.date)="' . $p_year . '" and payment.type_pay_id="' . $pay_type->id . '" and  user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
    } else {
        $p = (int) Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . $p_month . '" and year(payment.date)="' . $p_year . '" and payment.type_pay_id="' . $pay_type->id . '" and  user.id=' . Yii::$app->session['user']->id . '')->queryScalar();
    }
    if (empty($p)) {
        $p = 0;
    }
    $month[] = $pay_type->name . "<br/>" . number_format($p, 2) . " ກີບ";
    if (empty($p_all)) {
        $data[] = 0;
    } else {
        $data[] = ceil(($p * 100) / $p_all);
    }
}

echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    'options' => [
// 'colors' => ['red', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
        'title' => [
            'text' => 'ສົມ​ທຽບ​ການ​ຈ່າຍ​ໃນ​ເດືອນ ' . $p_month . '',
        ],
        'xAxis' => [
            'categories' => $month,
        ],
        'labels' => [
            'items' => [
                [
                    //   'html' => 'Total fruit consumption',
                    'style' => [
                        'left' => '50px',
                        'top' => '18px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'series' => [
            [
                'type' => 'column',
                'color' => '#3c8dbc',
                'name' => "ເດືອນ " . date('m'),
                'data' => $data,
            ],
        ],
    ]
]);
?>