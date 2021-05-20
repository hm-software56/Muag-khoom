<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\alert\Alert;

$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () {
    $("[data-toggle='tooltip']").tooltip();
});;
/* To initialize BS3 popovers set this below */
$(function () {
    $("[data-toggle='popover']").popover();
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
if (Yii::$app->session->hasFlash('su')) {
    echo Alert::widget([
        'type' => Alert::TYPE_SUCCESS,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok',
        'body' => Yii::$app->session->getFlash('su'),
        'showSeparator' => false,
        'delay' => 3000
    ]);
}
//echo date('dHi') + 5;
//echo Yii::$app->session['timeout'];
?>

<?php
if (!empty(Yii::$app->session['user'])) {
    ?>
    <div class="box box-solid bg-teal-gradient">
        <div class="box-header">
            <i class="fa fa-th"></i>

            <h3 class="box-title">ສົມ​ທຽບລາຍ​ຈ່າຍເປັ​ນ​ອາ​ທິດ</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-footer no-border">
            <?php
            $type_ps = \app\models\TypePay::find()->orderBy('sort ASC')->all();
            if (Yii::$app->session['user']->user_type == "Admin") {
                $amount_all = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where payment.date BETWEEN "' . date("Y-m-d", strtotime('monday this week')) . '" and "' . date("Y-m-d", strtotime('sunday this week')) . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
            } else {
                $amount_all = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment where date BETWEEN "' . date("Y-m-d", strtotime('monday this week')) . '" and "' . date("Y-m-d", strtotime('sunday this week')) . '" and user_id=' . Yii::$app->session['user']->id . '')->queryScalar();
            }

            if ($amount_all <= 0) {
                $amount_all = 0.1;
            }
            $i = 0;
            $h = array(1, 4, 7, 10);
            $f = array(3, 6, 9, 12);
            foreach ($type_ps as $type_p) {

                if (Yii::$app->session['user']->user_type == "Admin") {
                    $amount = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id  where payment.date BETWEEN "' . date("Y-m-d", strtotime('monday this week')) . '" and "' . date("Y-m-d", strtotime('sunday this week')) . '"  and type_pay_id=' . $type_p->id . ' and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                } else {
                    $amount = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment where date BETWEEN "' . date("Y-m-d", strtotime('monday this week')) . '" and "' . date("Y-m-d", strtotime('sunday this week')) . '"  and type_pay_id=' . $type_p->id . '  and user_id=' . Yii::$app->session['user']->id . '')->queryScalar();
                }
                if (ceil(($amount * 100) / $amount_all) <= 25) {
                    $bg = "#108326";
                } elseif (ceil(($amount * 100) / $amount_all) > 25 && ceil(($amount * 100) / $amount_all) <= 65) {
                    $bg = "#fad00d";
                } else {
                    $bg = "#fa0d1e";
                }
                $i++;
                if (in_array($i, $h)) {
                    echo "<div class='row'>";
                }
                ?>

                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4;">
                    <input type="text" class="knob" data-readonly="true" value="<?= ceil(($amount * 100) / $amount_all) ?>" data-width="60" data-height="60" data-fgColor="<?= $bg ?>">
                    <div class="knob-label">
                        <a  style="color: #000" tabindex="0"   data-toggle="popover<?= $i ?>" data-placement="top" data-trigger="focus"  data-content="<?= number_format($amount, 2) ?>ກີບ">
                            <?= $type_p->name ?>
                        </a>
                    </div>
                </div>
                <?php
                if (in_array($i, $f)) {
                    echo "</div>";
                } elseif ($i == count($type_ps)) {
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <div class="box box-solid bg-teal-gradient">
        <div class="box-header" style="background: #5ea7f4;">
            <i class="fa fa-th"></i>

            <h3 class="box-title">ສົມ​ທຽບລາຍ​ຈ່າຍເປັ​ນ​ເດືອນ</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm" data-widget="collapse" style="background: #569be5"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-sm" data-widget="remove" style="background: #569be5"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-footer no-border">
            <?php
            $type_ps = \app\models\TypePay::find()->orderBy('sort ASC')->all();
            if (Yii::$app->session['user']->user_type == "Admin") {
                $amount_all_m = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . date('m') . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
            } else {
                $amount_all_m = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment where month(date)="' . date('m') . '" and user_id=' . Yii::$app->session['user']->id . '')->queryScalar();
            }
            if ($amount_all_m <= 0) {
                $amount_all_m = 0.1;
            }
            $i = 0;
            $h = array(1, 4, 7, 10);
            $f = array(3, 6, 9, 12);
            foreach ($type_ps as $type_p) {

                if (Yii::$app->session['user']->user_type == "Admin") {
                    $amount_m = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . date('m') . '" and type_pay_id=' . $type_p->id . ' and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                } else {
                    $amount_m = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment where month(date)="' . date('m') . '"  and type_pay_id=' . $type_p->id . '  and user_id=' . Yii::$app->session['user']->id . '')->queryScalar();
                }
                if (ceil(($amount_m * 100) / $amount_all_m) <= 25) {
                    $bg = "#108326";
                } elseif (ceil(($amount_m * 100) / $amount_all_m) > 25 && ceil(($amount_m * 100) / $amount_all_m) <= 65) {
                    $bg = "#fad00d";
                } else {
                    $bg = "#fa0d1e";
                }
                $i++;
                if (in_array($i, $h)) {
                    echo "<div class='row'>";
                }
                ?>

                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4;">
                    <input type="text" class="knob" data-readonly="true" value="<?= ceil(($amount_m * 100) / $amount_all_m) ?>" data-width="60" data-height="60" data-fgColor="<?= $bg ?>">
                    <div class="knob-label">
                        <a  style="color: #000" tabindex="0"   data-toggle="popover_m<?= $i ?>" data-placement="top" data-trigger="focus"  data-content="<?= number_format($amount_m, 2) ?>ກີບ">
                            <?= $type_p->name ?>
                        </a>
                    </div>
                </div>
                <?php
                if (in_array($i, $f)) {
                    echo "</div>";
                } elseif ($i == count($type_ps)) {
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>


    <div class="box box-solid bg-teal-gradient">
        <div class="box-header" style="background: #059e17;">
            <i class="fa fa-th"></i>

            <h3 class="box-title">ສົມ​ທຽບລາຍ​ຈ່າຍເປັ​ນ​ປີ</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-sm" data-widget="collapse" style="background: #039714"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-sm" data-widget="remove" style="background: #039714"><i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-footer no-border">
            <?php
            $type_ps = \app\models\TypePay::find()->orderBy('sort ASC')->all();
            if (Yii::$app->session['user']->user_type == "Admin") {
                $amount_all_y = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where year(payment.date)="' . date('Y') . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
            } else {
                $amount_all_y = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment where year(date)="' . date('Y') . '" and user_id=' . Yii::$app->session['user']->id . '')->queryScalar();
            }

            if ($amount_all_y <= 0) {
                $amount_all_y = 0.1;
            }
            $i = 0;
            $h = array(1, 4, 7, 10);
            $f = array(3, 6, 9, 12);
            foreach ($type_ps as $type_p) {

                if (Yii::$app->session['user']->user_type == "Admin") {
                    $amount_y = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where year(payment.date)="' . date('Y') . '" and type_pay_id=' . $type_p->id . ' and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                } else {
                    $amount_y = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment where year(date)="' . date('Y') . '"  and type_pay_id=' . $type_p->id . '  and user_id=' . Yii::$app->session['user']->id . '')->queryScalar();
                }
                if (ceil(($amount_y * 100) / $amount_all_y) <= 25) {
                    $bg = "#108326";
                } elseif (ceil(($amount_y * 100) / $amount_all_y) > 25 && ceil(($amount_y * 100) / $amount_all_y) <= 65) {
                    $bg = "#fad00d";
                } else {
                    $bg = "#fa0d1e";
                }
                $i++;
                if (in_array($i, $h)) {
                    echo "<div class='row'>";
                }
                ?>

                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4;">
                    <input type="text" class="knob" data-readonly="true" value="<?= ceil(($amount_y * 100) / $amount_all_y) ?>" data-width="60" data-height="60" data-fgColor="<?= $bg ?>">
                    <div class="knob-label">
                        <a  style="color: #000" tabindex="0"   data-toggle="popover_y<?= $i ?>" data-placement="top" data-trigger="focus"  data-content="<?= number_format($amount_y, 2) ?>ກີບ">
                            <?= $type_p->name ?>
                        </a>
                    </div>
                </div>
                <?php
                if (in_array($i, $f)) {
                    echo "</div>";
                } elseif ($i == count($type_ps)) {
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
    <?php
}
?>

