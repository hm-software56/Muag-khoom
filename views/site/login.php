<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\alert\Alert;
echo Yii::$app->getUrlManager()->getBaseUrl();
$this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/login.css");
$this->title =Yii::t('app','ເຂົ້າ​ລະ​ບົບ');

?>
<div class="wrapper1 fadeInDown">
  <div id="formContent">
    <div class="fadeIn first">
    <img src="<?=Yii::$app->request->baseUrl?>/images/thume/<?=\Yii::$app->session['profile']->logo?>" class="img-circle" width="60" />
    <div class="line_bottom"> <?=\Yii::$app->session['profile']->shop_name?></div>
    </div>

    <!-- Login Form -->
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal', 'autocomplete' => "off"],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
    ]);
    ?>
    <input type="hidden" id="height_screen" name="hsc">
    <input type="hidden" id="width_screen" name="wsc">
    <script>
        document.getElementById('height_screen').value = window.innerHeight;
        document.getElementById('width_screen').value = window.innerWidth;
    </script>
    <?php
    if(!empty(\Yii::$app->session['height_screen']))
    {
        $n= Yii::$app->session['height_screen'] - 75;
       // $height='height:'.$n.'px';
        $height=null;
    }else{
        $height=null;
    }
    ?>
            <div class="login-box1 "  style="margin-top: 0px; <?=$height ?> " >
                <div class="login-box-body">
                    <!--<div class="form-group has-feedback">
                        <div class="line_bottom"><?= Yii::t('app', 'ປ້ອນຊື່ເຂົ້າ​ລະ​ບົບ ແລະ ລະ​ຫັດ​ຜ່ານ')?></div>

                    </div>-->
                    <div class="col-md-12">
                <?php
                    if (Yii::$app->session->hasFlash('su')) {
                        echo Alert::widget([
                            'type' => Alert::TYPE_DANGER,
                            'title' => Yii::$app->session->getFlash('action'),
                            'icon' => 'glyphicon glyphicon-alert',
                            'body' => Yii::$app->session->getFlash('su'),
                            'showSeparator' => false,
                            'delay' => 5000
                        ]);
                    }
                    if (Yii::$app->session->hasFlash('reg')) {
                        echo Alert::widget([
                            'type' => Alert::TYPE_SUCCESS,
                            'title' => Yii::$app->session->getFlash('action'),
                            'icon' => 'glyphicon glyphicon-ok',
                            'body' => Yii::$app->session->getFlash('reg'),
                            'showSeparator' => false,
                            'delay' => 12000
                        ]);
                    }
                ?>
            <div>
            <div class="form-group has-feedback">
                <input type="text" name="LoginForm[username]" class="fadeIn second" placeholder="<?= Yii::t('app', 'ຊື່​ເຂົ້າ​ລະ​ບົບ')?>" value="<?= $model->username ?>" >
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="LoginForm[password]" class=" fadeIn second" placeholder="<?= Yii::t('app', 'ລະ​ຫັດ​ເຂົ້າ​ລະ​ບົບ')?>" value="<?= $model->password ?>" >
                </div>
            <div class="form-group has-feedback">
                <div class="col-md-12" align="center">
                <div class="col-md-12" id="pdbt">
                    <button type="submit" class="btn btn-primary" onclick="onclick_loadimg()"><span class="fa fa-lock" ></span> <?= Yii::t('app','ເຂົ້າ​ລະ​ບົບ')?></button>
                </div>
                </div>
            </div>
            <!--<div class="text-red" >Login: <b>user</b> || Password:<b>12345</b></div>-->
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
    
    <div class="pull-right" style="padding:10px">
        <?php
        $key_acitvated=\Yii::$app->session['key_acitvated'];
            if(empty($key_acitvated) || date('Y-m-d',strtotime(Yii::$app->params['alert_date']))>$key_acitvated)
            {
        ?>
                <?php 
                $atkey=\app\models\ShopProfile::find()->one();
                $key=$atkey->key_active;
                $key_acitvated=substr($key,25,2).substr($key,17,-8)."-".substr($key,6,-19)."-".substr($key,0,-25);
                if(date('Y-m-d',strtotime(Yii::$app->params['alert_date']))>$key_acitvated)
                {
                    echo "<span style='color:red'><< ".Yii::t('app','​ໝົດອາ​ຍຸ​ນຳ​ໃຊ້ວັນ​ທີ: ').$key_acitvated." >></span>";
                }
                ?>
        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_key"><b><?=Yii::t('app','Activate key')?></b></button>
        <?php
            } 
        ?>
    </div>
  </div>
</div>
<?=$this->render('key')?>