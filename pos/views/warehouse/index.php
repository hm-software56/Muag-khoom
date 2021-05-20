<?php
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Warehouse')
?>
    <div class="line_bottom" style="padding-bottom: 10px; margin-bottom: 10px">
        <?= $this->title ?>
    </div>
<?php
if (empty(Yii::$app->session['user']->branch_id)) {
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-pie-chart"></i></span>
            <div class="info-box-content"
                 style="<?= (Yii::$app->session['user']->user_type == "POS") ? 'padding-top:20px;' : '' ?>">
                <div align="center">
                    <span class="info-box-text"><b><?= Yii::t('app', 'Warehouse') ?></b></span>
                    <span class="info-box-text"><?= Yii::t('app', 'Main') ?><small></small></span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 0%"></div>
                </div>
                <span class="progress-description">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="color:red">
                                <a href="<?= \yii\helpers\Url::toRoute(['products/index', 'branch_id' => 0]) ?>">
                                <il class="fa fa-eye"></il> <?= Yii::t('app', 'ເບີ່ງລາຍລະອຽດ') ?>
                                </a>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <span style="color:green">
                                <a href="<?= \yii\helpers\Url::toRoute(['product-transfer/index']) ?>">
                                <il class="fa fa-transgender"></il> <?= Yii::t('app', 'ໂອນສີນຄ້າໃຫ້ສາຂາ') ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php
if (empty(Yii::$app->session['user']->branch_id)) {
    $branchs = \app\models\Branch::find()->all();
} else {
    $branchs = \app\models\Branch::find()->where(['id' => Yii::$app->session['user']->branch_id])->all();
}
foreach ($branchs as $branch) {
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon "
                  style=" color: #ffffff; background: <?= sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>"><i
                        class="fa fa-pie-chart"></i></span>
            <div class="info-box-content"
                 style="<?= (Yii::$app->session['user']->user_type == "POS") ? 'padding-top:20px;' : '' ?>">
                <div align="center">
                    <span class="info-box-text"><b><?= Yii::t('app', 'Warehouse') ?></b></span>
                    <span class="info-box-text"><?= $branch->branch_name ?><small></small></span>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: 0%"></div>
                </div>
                <span class="progress-description">
                    <div class="row">
                        <div class="col-md-6">
                            <span style="color:red">
                                <a href="<?= \yii\helpers\Url::toRoute(['products/index', 'branch_id' => $branch->id]) ?>">
                                <il class="fa fa-eye"></il> <?= Yii::t('app', 'ເບີ່ງລາຍລະອຽດ') ?>
                                </a>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <span style="color:green">
                                <a href="<?= \yii\helpers\Url::toRoute(['product-transfer/index']) ?>">
                                <il class="fa fa-transgender"></il> <?= Yii::t('app', 'ເບີ່ງສີນຄ້າໂອນໃຫ້') ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
    <?php
}
?>