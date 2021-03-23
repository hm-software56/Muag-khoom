<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php
        $bg = array('bg1.jpg', 'bg2.jpg', 'bg3.jpg', 'bg4.jpg'); 
        //$bg = array('bg1.jpg');
        $i = rand(0, count($bg)-1); 
        $selectedBg = Yii::$app->urlManager->baseUrl."/images/bg/"."$bg[$i]";
    ?>
    <style type="text/css">
        .wrap {
            background: url('<?=$selectedBg?>') no-repeat center center fixed !important;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif, "Phetsarath OT" !important;
            //background: url('http://192.168.50.18:8080/images/bg.jpg') no-repeat center center fixed !important;
            -webkit-background-size: cover !important;
            -moz-background-size: cover !important;
            background-size: cover !important;
            -o-background-size: cover !important;
}
    </style>
</head>

<body>
    <div id = "loader">
            <span id="text-medel"><img   src = "<?= Yii::$app->urlManager->baseUrl ?>/images/loading.gif" style="width:50px"></span>
    </div>
    <?php $this->beginBody() ?>

    <div class="wrap">
        
        <div class="container" id="pdd">
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>