<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;

//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;

use yii\widgets\Breadcrumbs;

AppAsset::register($this);

if (Yii::$app->session->hasFlash('success')) {
    if (Yii::$app->session->hasFlash('title')) {
        $title = Yii::$app->session->getFlash('title');
    } else {
        $title = Yii::t('app', 'ສໍາເລັດ.!');
    }
    $text = Yii::$app->session->getFlash('success');

    $script = <<< JS
    Swal.fire({
  title:"$title",
  icon: 'success',
  html:"$text",
  showDenyButton:false,
  showConfirmButton: false,
});
JS;
    $this->registerJs($script);
} else if (Yii::$app->session->hasFlash('error')) {
    if (Yii::$app->session->hasFlash('title')) {
        $title = Yii::$app->session->getFlash('title');
    } else {
        $title = Yii::t('app', 'ຜິດພາດ.!');
    }
    $text = Yii::$app->session->getFlash('error');

    $script = <<< JS
    Swal.fire({
  title:"$title",
  icon: 'warning',
  html:"$text",
  showDenyButton:false,
  showConfirmButton: false,
});
JS;
    $this->registerJs($script);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::$app->urlManager->baseUrl ?>/icon1.ico"/>
    <?php $this->head() ?>
    <style>
        <?php
        if(!empty(Yii::$app->session['mobile']))
        {
        ?>
        .main-header .logo {
            height: 75px !important;
        }

        .skin-blue .main-header .logo {
            padding-top: 25px !important;
        }

        .content {
            margin-top: 125px !important;
        }

        .main-sidebar, .left-side {
            padding-top: 125px;
        }

        <?php
        }
        ?>
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader">
    <span id="text-medel"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/loading.gif" style="width:50px"></span>
</div>
<?php $this->beginBody() ?>
<div class="wrapper">

    <header class="main-header navbar-fixed-top">
        <!-- Logo -->
        <?php
        $profle = \app\models\ShopProfile::find()->one();
        if (!empty(Yii::$app->session['user'])) {
            ?>
            <a class="logo" href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/dashbord">
                <span class="logo-mini"><?= $profle->shop_name ?></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?= $profle->shop_name ?></span>
            </a>
            <?php
        } else {
            ?>
            <a class="logo">
                <span class="logo-mini"><?= $profle->shop_name ?></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><?= $profle->shop_name ?></span>
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
                        $prd = \app\models\Products::find()->where('status=1 and qautity<=' . $profle->alert . '')->count();
                        ?>
                        <li class="dropdown messages-menu">
                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/productfinish"
                               onclick="onclick_loadimg()">
                                <span class="label label-danger"
                                      style="right: 80px !important; "><?= ($prd > 0) ? $prd : '' ?></span>
                                <i class="fa fa-bullhorn"></i>
                                <?= Yii::t('app', 'ສີນຄ້າໝົດ') ?>

                            </a>
                        </li>
                        <!--<li class="dropdown user user-menu">
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/sale" onclick="onclick_loadimg()">
                                        <span class="glyphicon glyphicon-share-alt"></span><?= Yii::t('app', 'ຮ້ານອາຫານ') ?>
                                    </a>
                                </li>-->

                        <li class="dropdown user user-menu">
                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/sale"
                               onclick="onclick_loadimg()">
                                <span class="glyphicon glyphicon-shopping-cart"></span><?= Yii::t('app', 'ຂາຍໜ້າຮ້ານ(POS)') ?>
                            </a>
                        </li>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= Yii::$app->session['user']->photo ?>"
                                     class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= Yii::$app->session['user']->first_name ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= Yii::$app->session['user']->photo ?>"
                                         class="img-circle" alt="User Image">

                                    <p>
                                        <?= Yii::$app->session['user']->first_name ?>
                                        <small><?= Yii::$app->session['user']->last_name ?></small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer bg-blue">
                                    <div class="pull-left">
                                        <a onclick="onclick_loadimg()"
                                           href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=user/update&prof=true&id=<?= Yii::$app->session['user']->id ?>"
                                           class="btn bg-green btn-sm"><span class="fa fa-cogs"></span></a>
                                    </div>
                                    <div class="pull-right">
                                        <a onclick="onclick_loadimg()"
                                           href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/logout"
                                           class="btn bg-red btn-sm"><span class="fa fa-power-off"></span></a>
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
                        <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= Yii::$app->session['user']->photo ?>"
                             class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= Yii::$app->session['user']->first_name ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i><?= Yii::t('app', 'ກຳລັງໃຊ້ງານ') ?></a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header"><?= Yii::t('app', 'ເມນູຫຼັກ') ?></li>

                    <?php
                    if (Yii::$app->session['user']->user_type == "Admin" || Yii::$app->session['user']->user_type == "User") {
                        ?>
                        <li>
                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products">
                                <i class="fa fa-th"></i> <span><?= Yii::t('app', 'ຈັດການສີ້ນຄ້າ') ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-sellsy"></i> <span><?= Yii::t('app', 'ສີນຄ້າ') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=purchase"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-sellsy"></i>
                                        <span><?= Yii::t('app', 'ຈັດຊື້ສີນຄ້າ') ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/checkpd"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-sellsy"></i>
                                        <span><?= Yii::t('app', 'ກວດເບີ່ງສີນຄ້າ') ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/sale"
                               onclick="onclick_loadimg()">
                                <i class="fa fa-shopping-cart "></i> <span><?= Yii::t('app', 'ຂາຍສີ້ນຄ້າ') ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-bar-chart"></i> <span><?= Yii::t('app', 'ລາຍງານ') ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/product"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-bar-chart"></i><?= Yii::t('app', 'ສີ້ນຄ້າທີ່ຍັງເຫຼືອ') ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/productfinish"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-bar-chart"></i><?= Yii::t('app', 'ສີ້ນຄ້າທີ່ໝົດແລ້ວ') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/repaortsale"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-bar-chart"></i><?= Yii::t('app', 'ສີ້ນຄ້າຂາຍແລ້ວ') ?></a>
                                </li>
                                <!--<li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/repsaleornot" onclick="onclick_loadimg()">
                                                <i class="fa fa-ra"></i>ສີ້ນຄ້າຂາຍແລ້ວ ແລະ ຍັງເຫຼືອ</a>
                                        </li> -->

                            </ul>
                        </li>
                        <?php
                        if (Yii::$app->session['user']->user_type == "Admin") {
                            ?>
                            <li>
                                <a href="#">
                                    <i class="fa fa-gears"></i> <span><?= Yii::t('app', 'ຕັ້ງຄ່າ') ?></span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=category/index"
                                           onclick="onclick_loadimg()">
                                            <i class="fa fa-sellsy"></i>
                                            <span><?= Yii::t('app', 'ປະເພດສີນຄ້າ') ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=currency/index"
                                           onclick="onclick_loadimg()">
                                            <i class="fa fa-sellsy"></i>
                                            <span><?= Yii::t('app', 'ສະກຸນເງີນ') ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/gbarcode"
                                           onclick="onclick_loadimg()">
                                            <i class="fa fa-barcode"></i>
                                            <span><?= Yii::t('app', 'ລະຫັດບາໂຄດ') ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=shop-profile/update&id=1"
                                           onclick="onclick_loadimg()">
                                            <i class="fa fa-user"></i> <span><?= Yii::t('app', 'ຂໍ້ມູນຮ້ານ') ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=branch/index"
                                           onclick="onclick_loadimg()">
                                            <i class="fa fa-user"></i> <span><?= Yii::t('app', 'ສາຂາ') ?></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=user"
                                           onclick="onclick_loadimg()">
                                            <i class="fa fa-user"></i>
                                            <span><?= Yii::t('app', 'ຜູ້ໃຊ໊ລະບົບ') ?></span>
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
                                <i class="fa fa-bar-chart"></i> <span><?= Yii::t('app', 'ລາຍງານ') ?></span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/product"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-bar-chart"></i><?= Yii::t('app', 'ສີ້ນຄ້າຍັງເຫຼືອ') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/productfinish"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-bar-chart"></i><?= Yii::t('app', 'ສີ້ນຄ້າທີ່ໝົດແລ້ວ') ?></a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=products/repaortsale"
                                       onclick="onclick_loadimg()">
                                        <i class="fa fa-bar-chart"></i><?= Yii::t('app', 'ສີ້ນຄ້າຂາຍແລ້ວ') ?></a>
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
        <section class="content">
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => Yii::t('app', 'ໜ້າຫຼັກ'), 'url' => ['products/dashbord']],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
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
                <?php
                $key_acitvated = \Yii::$app->session['key_acitvated'];
                if (empty($key_acitvated) || date('Y-m-d', strtotime(Yii::$app->params['alert_date'])) > $key_acitvated) {
                    ?>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_key">
                        <b><?= Yii::t('app', 'Activate key') ?></b></button>
                    <?php
                }
                ?>

                <div id="modal_key" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <?php $form = ActiveForm::begin(['action' => ['site/key']]); ?>
                                <?php
                                if (Yii::$app->session->hasFlash('success_key')) {
                                    ?>
                                    <h2 style="color:green"><?= Yii::$app->session->getFlash('success_key') ?></h2>
                                    <?php
                                } else {
                                    ?>
                                    <?php
                                    echo Html::textInput('key', '', ['autocomplete' => "off", 'placeholder' => Yii::t('app', 'Key'), 'class' => 'form-control']);
                                    ?>
                                    <?php
                                    if (Yii::$app->session->hasFlash('error_key')) {
                                        ?>
                                        <h5 style="color:red"><?= Yii::$app->session->getFlash('error_key') ?></h5>
                                        <?php
                                    }
                                    ?>
                                    <div class="modal-footer">
                                        <button type="submit"
                                                class="btn btn-primary"><?= Yii::t('app', 'Activate') ?></button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">ໂທ: +(856 21) 216066</div>
                <div class="col-md-2"> ອິເມວ: web@cyberia.la</div>
            </div>
        </footer>
        <?php
    }
    ?>
</div>
<?php $this->endBody() ?>
<?php
$currency = \app\models\Currency::find()->where(['base_currency' => 1])->one();
?>
<script>
    jQuery(function ($) {
        $('#money').autoNumeric('init', {aSign: ' <?=$currency->name?>', pSign: 's'});
    });
    jQuery(function ($) {
        $('#money_dao').autoNumeric('init', {aSign: ' ກີບ', pSign: 's'});
    });

    $('#detail-modal').on('hidden.bs.modal', function () {
        location.reload();
    })

</script>

<script>
    <?php
    if (Yii::$app->controller->action->id == 'gbarcode') {
    if (!empty(Yii::$app->session['prdbc'])) {
        $products = \app\models\Products::find()->where(['id' => Yii::$app->session['prdbc']])->all();
    } else {
        $products = \app\models\Products::find()->all();
    }
    $i = 0;
    foreach ($products as $product) {
    $i++;
    for ($a = 1; $a <= Yii::$app->session['nbbc'];$a++) {
    ?>
    JsBarcode(".barcode<?= $i . $a ?>").init();
    <?php
    }
    }
    }
    ?>

</script>
<?php
if (Yii::$app->session->hasFlash('success_key') || Yii::$app->session->hasFlash('error_key')) {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#modal_key").modal('show');
        });
    </script>
    <?php
}
?>

</body>
</html>
<?php $this->endPage() ?>
