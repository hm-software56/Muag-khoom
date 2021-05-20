<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="modal-body">
    <?php $form = ActiveForm::begin(['action' => ['site/key'], 'options' => ['autocomplete' => 'off']]); ?>
    <?php
    if (Yii::$app->session->hasFlash('success_key')) {
        ?>
        <h2 style="color:green"><?= Yii::$app->session->getFlash('success_key') ?></h2>
        <?php
    } else {
        ?>
        <div class="row">
            <div class="col-md-12" align="center">
                <?php
                echo Html::textInput('key', '', ['autocomplete' => "off", 'required' => 'required', 'placeholder' => Yii::t('app', 'ປ້ອນລະຫັດ Activate'), 'class' => 'fadeIn second ']);
                ?>
            </div>
            <div class="col-md-12" align="center">
                <button type="submit" class="btn btn-primary "><span
                            class="fa fa-key"></span> <?= Yii::t('app', 'Activate') ?></button>
            </div>
            <div class="col-md-12">
                <?php
                if (Yii::$app->session->hasFlash('error_key')) {
                    ?>
                    <h5 style="color:red"
                        align="center"><?= Yii::$app->session->getFlash('error_key') ?></h5>
                    <?php
                }
                ?>
            </div>
            <div align="center" style="padding:10px;">
                <span class="fa fa-volume-control-phone"></span> <?= Yii::t('app', 'ໂທ:') . "020 55045770;" ?> <?= Yii::t('app', 'ອີເມວ:') . "daxionginfo@gmail.com" ?>
            </div>

        </div>

        <?php
    }
    ?>
    <?php ActiveForm::end(); ?>
</div>