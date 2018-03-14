
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\alert\Alert;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
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
    <script>
        document.getElementById('height_screen').value = window.innerHeight;
    </script>
    <?php
    if(!empty(\Yii::$app->session['height_screen']))
    {
        $n= Yii::$app->session['height_screen'] - 75;
        $height='height:'.$n.'px';
    }else{
        $height=null;
    }
    ?>
    <div class="login-box "  style="margin-top: 0px; <?=$height ?> " >
        <div class="login-box-body">
            <div class="form-group has-feedback">
                <div class="line_bottom"><?= Yii::t('app', 'ປ້ອນຊື່ເຂົ້າ​ລະ​ບົບ ແລະ ລະ​ຫັດ​ຜ່ານ')?></div>

            </div>
            <div class="form-group has-feedback">
                <input type="text" name="LoginForm[username]" class="form-control" placeholder="<?= Yii::t('app', 'ຊື່​ເຂົ້າ​ລະ​ບົບ')?>" value="<?= $model->username ?>" required >
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="LoginForm[password]" class="form-control" placeholder="<?= Yii::t('app', 'ລະ​ຫັດ​ເຂົ້າ​ລະ​ບົບ')?>" value="<?= $model->password ?>" required >
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <div class="col-xs-8">
                <?php 
                $atkey=\app\models\ShopProfile::find()->one();
                $key=$atkey->key_active;
                $key_acitvated=substr($key,25,2).substr($key,17,-8)."-".substr($key,6,-19)."-".substr($key,0,-25);
                if(date('Y-m-d',strtotime(Yii::$app->params['alert_date']))>$key_acitvated)
                {
                    echo "<span style='color:red'>".Yii::t('app','​ໝົດອາ​ຍຸ​ການ​ນຳ​ໃຊ້ວັນ​ທີ: ').$key_acitvated."</span>";
                }
                ?>
                </div>
                <div class="col-xs-4" style="padding-right: 0px;" align="right">
                    <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-lock" ></span><?= Yii::t('app','ເຂົ້າ​ລະ​ບົບ')?></button>
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end();
?>