<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="shortcut icon" href="<?=Yii::$app->urlManager->baseUrl?>/icon1.ico" />
        <?php $this->head() ?>
		<style>
			<?php
			if(!empty(Yii::$app->session['mobile']))
			{
			?>
			.skin-blue .main-header .navbar {
			   padding-top:  25px!important;
			}
			.content {
				margin-top: 125px !important;
			}
			<?php
			}
			?>
		</style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
	<div id = "loader">
            <span id="text-medel"><img   src = "<?= Yii::$app->urlManager->baseUrl ?>/images/loading.gif" style="width:50px"></span>
        </div>
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <header class="main-header navbar-fixed-top">
                <!-- Logo -->
                <?php
                $profle=\app\models\ShopProfile::find()->one();
                if (!empty(Yii::$app->session['user'])) {
                    ?>
                    <a onclick="onclick_loadimg()" class="logo hidden-xs" href="<?=Yii::$app->urlManager->baseUrl?>/index.php?r=products/dashbord">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><?=$profle->shop_name?></span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><?=$profle->shop_name?></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><?=$profle->shop_name?></span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg"><?=$profle->shop_name?></span>
                    </a>
                    <?php
                }
                ?>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <?php
                    if (!empty(Yii::$app->session['user'])) {
                        ?>
                        <a href="#" class="sidebar-toggle hidden-xs" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <?php
                    }
                    ?>
                    <div class="navbar-custom-menu">

                        <ul class="nav navbar-nav">
                            
                            <?php
                            if (!empty(Yii::$app->session['user'])) {
                                ?>
                                <?php 
                                $stillpay = \app\models\StillPay::find()->where(['status' => '1'])->count();
                                
                                ?>
                                <li class="dropdown messages-menu">
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=still-pay/index" onclick="onclick_loadimg()">
                                        <span class="label label-danger"><?=($stillpay>0)? $stillpay :''?></span>
                                        <i class="fa fa-bell-o"></i>
                                        <?= Yii::t('app', 'ໜິ​ຄ້າງ') ?>
                                        
                                    </a>
                                </li>

                                <li class="dropdown user user-menu">
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/canclesale" onclick="onclick_loadimg()">
                                        <span class="fa fa-trash"></span><?= Yii::t('app', 'ຍົກ​ເລີ​ກ​ສີ້ນ​ຄ້າ​ທີ​ຂາຍ')?>
                                    </a>
                                </li>
                                <?php
                                if (Yii::$app->session['user']->user_type == "POS") {
                                    ?>
                                    <li class="dropdown user user-menu">
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/dashbord" onclick="onclick_loadimg()">
                                            <span class="glyphicon glyphicon-home"></span><?= Yii::t('app', 'ໜ້າຫຼັກ')?>
                                        </a>
                                    </li>

                                    <?php
                                } else {
                                    ?>
                                    <li class="dropdown user user-menu">
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/dashbord" onclick="onclick_loadimg()">
                                            <span class="glyphicon glyphicon-home"></span><?= Yii::t('app', 'ໜ້າຫຼັກ')?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li class="dropdown user user-menu hidden-xs">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= Yii::$app->session['user']->photo ?>" class="user-image" alt="User Image">
                                        <span class="hidden-xs"><?= Yii::$app->session['user']->first_name ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li class="user-header">
                                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= Yii::$app->session['user']->photo ?>" class="img-circle" alt="User Image">

                                            <p>
                                                <?= Yii::$app->session['user']->first_name ?>
                                                <small><?= Yii::$app->session['user']->last_name ?></small>
                                            </p>
                                        </li>

                                        <!-- Menu Footer-->
                                        <li class="user-footer bg-blue">
                                            <div class="pull-left">
                                                <a onclick="onclick_loadimg()" href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=user/update&prof=true&id=<?= Yii::$app->session['user']->id ?>" class="btn bg-green btn-sm"><span class="fa fa-cogs"></span></a>
                                            </div>
                                            <div class="pull-right">
                                                <a onclick="onclick_loadimg()" href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/logout" class="btn bg-red btn-sm"><span class="fa fa-power-off"></span></a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Control Sidebar Toggle Button -->
                                <?php
                            }
                            ?>
                        </ul>

                    </div>
                </nav>
            </header>
            <section class="content" id="hdm" style="background: #fff" >

                <?= $content ?>

            </section>
            <?php
            if (empty(\Yii::$app->session['user'])) {
                ?>
                <footer class="main-footer">
                    <div class="pull-right">
                        Version 1.2
                    </div>
                    ໂທ: 020 55045770
                </footer>
                <?php
            }
            ?>
        </div>
        <?php $this->endBody() ?>
        <script>
            jQuery(function ($) {
                $('#money').autoNumeric('init', {aSign: ' ກີບ', pSign: 's'});
            });
            jQuery(function ($) {
                $('#money_dao').autoNumeric('init', {aSign: ' ກີບ', pSign: 's'});
            });
            jQuery(function ($) {
                $('#textpice').autoNumeric('init', {aSign: ' ກີບ', pSign: 's'});
            });
        </script>

    </body>
</html>
<?php $this->endPage() ?>
