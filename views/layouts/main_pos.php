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
        <?php $this->head() ?>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">

            <header class="main-header navbar-fixed-top">
                <!-- Logo -->
                <?php
                $profle=\app\models\ShopProfile::find()->one();
                if (!empty(Yii::$app->session['user'])) {
                    ?>
                    <a class="logo" href="<?=Yii::$app->urlManager->baseUrl?>/index.php?r=products/dashbord">
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
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
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
                                <li class="dropdown user user-menu">
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/sale">
                                        <span class="glyphicon glyphicon-shopping-car t"></span><?= Yii::t('app', 'ຂາຍ​ສີ້ນ​ຄ້າໜ້າ​ຮ້ານ (POS)')?>
                                    </a>
                                </li>
                                <?php
                                if (Yii::$app->session['user']->user_type == "POS") {
                                    ?>
                                    <li class="dropdown user user-menu">
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/dashbord">
                                            <span class="glyphicon glyphicon-home"></span><?= Yii::t('app', 'ໜ້າຫຼັກ')?>
                                        </a>
                                    </li>

                                    <?php
                                } else {
                                    ?>
                                    <li class="dropdown user user-menu">
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/dashbord">
                                            <span class="glyphicon glyphicon-home"></span><?= Yii::t('app', 'ໜ້າຫຼັກ')?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li class="dropdown user user-menu">
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
                                                <a  href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=user/update&prof=true&id=<?= Yii::$app->session['user']->id ?>" class="btn bg-green btn-sm"><span class="fa fa-cogs"></span></a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/logout" class="btn bg-red btn-sm"><span class="fa fa-power-off"></span></a>
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
            <section class="content" style="background: #fff" >

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
