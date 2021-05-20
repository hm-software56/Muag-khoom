<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
$this->title=Yii::t('app','Installer');
?>
<?php
if (Yii::$app->session->hasFlash('error')) {
    echo kartik\alert\Alert::widget([
        'type' => kartik\alert\Alert::TYPE_DANGER,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-alert',
        'body' => Yii::$app->session->getFlash('error'),
        'showSeparator' => false,
        'delay' => 500000
    ]);
}
?>
<?php $form = ActiveForm::begin(); ?>

<?php
if (Yii::$app->session['step'] ==1)
{
?>
<img src="images/step2.jpg">
<h3><?=Yii::t('app','ປ້ອນລາຍລະອຽດການຕິດຕໍ່ Server ແລະ ຖານຂໍ້ມູນ')?></h3>
<div class="row">
    <div class="col-md-4">
    <input value='<?= Yii::$app->session['host'] ?>' type="text" class="form-control" name="host" placeholder="localhost" required>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-4">
    <input value='<?= Yii::$app->session['username'] ?>' type="text" class="form-control" name="username" placeholder="username" required>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-4">
    <input value='<?= Yii::$app->session['password'] ?>' type="text" class="form-control" name="password" placeholder="password">
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-4">
    <input value='<?= Yii::$app->session['database'] ?>' type="text" class="form-control" name="database" placeholder="database name" required>
    </div>
</div>
<?php
}else if(Yii::$app->session['step']==2)
{
?>
    <img src="images/step3.jpg">
    <div class="row">
        <div class="col-md-12">
            <input autocomplete='off' value='<?= Yii::$app->session['key_install'] ?>' type="text" class="form-control" name="key_install" placeholder="linces key" required>
        </div>
    </div>
    <br/>
    <h5><?=Yii::t('app','ເລືອກ Database ທີ່ທ່ານຕ້ອງການໃຊ້')?></h5>
    <div class="row">
        <div class="col-md-4">
        <input type="radio" name="data" value="0" checked> Database ທີມີຂໍ້ມູນຕົວຢ່າງ<br>
        <input type="radio" name="data" value="1"> Database ຫວ່າງເປົ່າ<br>
        </div>
    </div>
<?php
} else if (Yii::$app->session['step'] == 3) {
    ?>
    <img src="images/step4.jpg">
    <h5><?=Yii::t('app', 'ປ້ອນຊື່ ແລະ ລະຫັດຂອງ administrator ເພື່ອເຂົ້າລະບົບ')?></h5>
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="user_admin" placeholder="username" required class="form-control">
        </div>
    </div>
    <br/>
    <div class="row">
         <div class="col-md-4">
            <input type="password" name="password_admin" placeholder="password" required class="form-control">
        </div>
    </div>
    
<?php

} else if (Yii::$app->session['step'] ==4) {
    ?>
    <img src="images/step5.jpg">
    <h5 style="color:green"><?=Yii::t('app','ທ່ານໄດ້ຕິດຕັ້ງລະບົບສຳເລັດແລ້ວ ກົດປຸ່ມຂ້າງລຸ່ມເພື່ອເຂົ້າຫາລະບົບ')?></h5>
    <a href="index.php?r=site/login&true=true" class="btn btn-danger btn-sm">Login >></a>
<?php

} else{
    ?>
    <img src="images/step1.jpg">
    <h3><?=Yii::t('app','ຄວາມຕ້ອງການຂອງລະບົບ')?></h3>
    <table class="table table-bordered">
            <tbody><tr><th>Name</th><th>Result</th><th>Required By</th><th>Memo</th></tr>
                <tr class="success">
                    <td>
                        <?= Yii::t('app', 'OS') ?>               
                    </td>
                    <td>
                        <span class="result"><?= Yii::t('app', 'ຜ່ານ') ?></span>
                    </td>
                    <td>
                       <?= Yii::t('app', 'HM-SOFTWARE') ?>
                    </td>
                    <td>
                        <?= Yii::t('app', 'Windows 8,10 ຫຼື Linux') ?>
                    </td>
                </tr>

                <tr class="success">
                    <td>
                        <?= Yii::t('app', 'PHP Version') ?>               
                    </td>
                    <td>
                        <span class="result"><?= Yii::t('app', 'ຜ່ານ') ?></span>
                    </td>
                    <td>
                       <?= Yii::t('app', 'HM-SOFTWARE') ?>
                    </td>
                    <td>
                        <a href="https://www.apachefriends.org/index.html" target='_blank'><?= Yii::t('app', 'PHP7.1 ຫຼື ສ​ູງ​ກ່າວນັ້ນ Click download') ?></a>
                    </td>
                </tr>  

                <tr class="success">
                    <td>
                        <?= Yii::t('app', 'Open file extension') ?>               
                    </td>
                    <td>
                        <span class="result"><?= Yii::t('app', 'ຜ່ານ') ?></span>
                    </td>
                    <td>
                       <?= Yii::t('app', 'HM-SOFTWARE') ?>
                    </td>
                    <td>
                        <?= Yii::t('app', 'ເພື່ອ​ຕ້ອງ​ກັນ​ໃຫ້ Upload file ທຸກ​ຊະ​ນິດ​ໄດ້') ?>
                    </td>
                </tr>
                
                <tr class="success">
                    <td>
                        <?= Yii::t('app', 'Open PDO extension') ?>               
                    </td>
                    <td>
                        <span class="result"><?= Yii::t('app', 'ຜ່ານ') ?></span>
                    </td>
                    <td>
                       <?= Yii::t('app', 'HM-SOFTWARE') ?>
                    </td>
                    <td>
                        <?= Yii::t('app', 'All DB-related classes') ?>
                    </td>
                </tr>
                
                <tr class="success">
                    <td>
                        <?= Yii::t('app', 'Open PDO MySQL extension') ?>               
                    </td>
                    <td>
                        <span class="result"><?= Yii::t('app', 'ຜ່ານ') ?></span>
                    </td>
                    <td>
                       <?= Yii::t('app', 'HM-SOFTWARE') ?>
                    </td>
                    <td>
                        <?= Yii::t('app', 'Required for MySQL database.') ?>
                    </td>
                </tr> 
            </tbody>
        </table>
    <?php
}
?>
<br/>
<?php
if (Yii::$app->session['step'] !== 4) {
?>
<div class="row" >
    <div class="col-md-4">
    <input type="submit" class="btn btn-primary" name="next" value="Next >>" >
    </div>
</div>
<?php
}
?>
<?php ActiveForm::end(); ?>