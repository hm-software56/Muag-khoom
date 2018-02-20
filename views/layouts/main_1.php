<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;

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
               
                    <a class="logo" href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/dashbord">
                         <span class="logo-mini">sss</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">POS</span>
                    </a>
                    
                    <a class="logo">
                        <span class="logo-mini">ssss</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">POS</span>
                    </a>
                   
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
                                        <span class="glyphicon glyphicon-shopping-cart"></span>ຂາຍ​ສີ້ນ​ຄ້າໜ້າ​ຮ້ານ (POS)
                                    </a>
                                </li>
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
            <!-- Left side column. contains the logo and sidebar -->
            <?php
            if (!empty(Yii::$app->session['user'])) {
                ?>
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= Yii::$app->session['user']->photo ?>" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info" >
                                <p><?= Yii::$app->session['user']->first_name ?></p>
                                <a href="#"><i class="fa fa-circle text-success"></i>ກຳ​ລັງ​ໃຊ້​ງານ</a>
                            </div>
                        </div>
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li class="header">ເມ​ນູ​ຫຼັກ</li>

                            <?php
                            if (Yii::$app->session['user']->user_type == "Admin" || Yii::$app->session['user']->user_type == "User") {
                                ?>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products">
                                        <i class="fa fa-th"></i> <span>ຈັດ​ການ​ສີ້ນ​ຄ້າ​ເຂົ້າ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/sale">
                                        <i class="fa fa-shopping-cart "></i> <span>​ຂາຍ​ສີ້ນ​ຄ້າ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-bar-chart"></i> <span>ລາຍ​ງານ​</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/product">
                                                <i class="fa fa-bar-chart"></i>​ສີ້ນ​ຄ້າທີ່​ຍັງ​ເຫຼືອ</a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/productfinish">
                                                <i class="fa fa-bar-chart"></i>​ສີ້ນ​ຄ້າທີ່​ໝົດ​ແລ້ວ</a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/repaortsale">
                                                <i class="fa fa-bar-chart"></i>​ສີ້ນ​ຄ້າ​ຂາຍ​ແລ້ວ</a>
                                        </li>
                                        <!--<li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/repsaleornot">
                                                <i class="fa fa-ra"></i>ສີ້ນ​ຄ້າ​ຂາຍ​ແລ້ວ ແລະ ຍັງ​ເຫຼືອ</a>
                                        </li> -->

                                    </ul>
                                </li>
                                <?php
                                if (Yii::$app->session['user']->user_type == "Admin") {
                                    ?>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-gears"></i> <span>ຕັ້​ງ​ຄ່າ</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li>
                                                <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=category/index">
                                                    <i class="fa fa-sellsy"></i> <span>ປະ​ເພດ​ສີນ​ຄ້າ</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/gbarcode">
                                                    <i class="fa fa-barcode"></i> <span>ລະ​ຫັດ​ບາ​ໂຄດ</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=shop-profile/update&id=1">
                                                    <i class="fa fa-user"></i> <span>ຂໍ້​ມູນ​ຮ້ານ</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=user">
                                                    <i class="fa fa-user"></i> <span>ຜ​ູ້​ໃຊ໊ລ​ະ​ບົບ</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php

                                }
                                ?>
                                <?php

                            }
                            ?>
                            <?php
                            if (Yii::$app->session['user']->user_type == "POS") {
                                ?>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-bar-chart"></i> <span>ລາຍ​ງານ​</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/product">
                                                <i class="fa fa-bar-chart"></i>​ສີ້ນ​ຄ້າ​ຍັງ​ເຫຼືອ</a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/productfinish">
                                                <i class="fa fa-bar-chart"></i>​ສີ້ນ​ຄ້າທີ່​ໝົດ​ແລ້ວ</a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/repaortsale">
                                                <i class="fa fa-bar-chart"></i>ສີ້ນ​ຄ້າ​ຂາຍ​ແລ້ວ</a>
                                        </li>

                                    </ul>
                                </li>
                                <?php

                            }
                            ?>
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>
                <?php

            }
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background: #fff">
                <section class="content" >
                    <?= $content ?>
                </section>
            </div>
            <!-- /.content-wrapper -->
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
       

    </body>
</html>
<?php $this->endPage() ?>
