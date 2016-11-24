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
                if (!empty(Yii::$app->session['user'])) {
                    ?>
                    <a class="logo" href="index.php?r=site/index">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>ລ</b>ກງ</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">​ລະ​ບົບ​ເກັບ​ກຳ​ເງີນ</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini"><b>ລ</b>ກງ</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">​ລະ​ບົບ​ເກັບ​ກຳ​ເງີນ</span>
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
                            if (Yii::$app->session['user']->user_type == "User") {
                                ?>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment">
                                        <i class="fa fa-th"></i> <span>ຈັດ​ການເງີນ​ທີ່​ຈ່າຍ​ອອກ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=dao-car">
                                        <i class="fa fa-th"></i> <span>ຈັດ​ການເງີນ​ທີ່​ຈ່າຍ​ຄ່າ​ລົດ​ໃຫຍ່</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=recieve-money">
                                        <i class="fa fa-th"></i> <span>ຈັດ​ການເງີນ​ທີ່​ຮັບ​ເຂົ້າ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-signal"></i> <span>ລາຍ​ງານ​</span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment/report">
                                                <i class="fa fa-sellsy"></i>ລາຍ​ງານ​ລາຍ​ຈ່າຍ</a>
                                        </li>
                                        <li>
                                            <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=recieve-money/report">
                                                <i class="fa fa-ra"></i>ລາຍ​ງານ​ລາຍ​ຮັບ</a>
                                        </li>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                            if (Yii::$app->session['user']->user_type == "Admin") {
                                ?>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=payment/report">
                                        <i class="fa fa-sellsy"></i>ລາຍ​ງານ​ລາຍ​ຈ່າຍ</a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=recieve-money/report">
                                        <i class="fa fa-ra"></i>ລາຍ​ງານ​ລາຍ​ຮັບ</a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=site/compare">
                                        <i class="fa fa-th"></i> <span>ສົ​ມ​ທຽບ​ລາຍ​ຮັບ​ລ່າຍ​ຈ່າຍ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManager->baseUrl ?>/index.php?r=user">
                                        <i class="fa fa-user"></i> <span>ຈັດ​ການຜູ້​ເຂົ້າ​ລະ​ບົບ</span>
                                    </a>
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
        <script>
            jQuery(function ($) {
                $('#money').autoNumeric('init', {aSign: ' ກີບ', pSign: 's'});
            });
            jQuery(function ($) {
                $('#money_dao').autoNumeric('init', {aSign: ' ໂດ​ລາ', pSign: 's'});
            });
        </script>
        <?php
        if (!empty(Yii::$app->session['user']) && Yii::$app->controller->action->id == "compare") {

            function weekOfMonth($qDate)
            {
                $dt = strtotime($qDate);
                $day = date('j', $dt);
                $month = date('m', $dt);
                $year = date('Y', $dt);
                $totalDays = date('t', $dt);
                $weekCnt = 1;
                $retWeek = 0;
                for ($i = 1; $i <= $totalDays; $i++) {
                    $curDay = date("N", mktime(0, 0, 0, $month, $i, $year));
                    if ($curDay == 7) {
                        if ($i == $day) {
                            $retWeek = $weekCnt + 1;
                        }
                        $weekCnt++;
                    } else {
                        if ($i == $day) {
                            $retWeek = $weekCnt;
                        }
                    }
                }
                return $retWeek;
            }

            $w = weekOfMonth(date('Y-m-d')) - 2;
            // exit;
            $r_w = array();
            $p_w = array();
            $label = array();
            $s = 0;
            for ($i = $w; $i >= 0; $i--) {
                $s++;
                $label[] = "ທິດ " . $s;
                $r_w[] = Yii::$app->db->createCommand('SELECT sum(amount)  FROM recieve_money LEFT JOIN user ON recieve_money.user_id=user.id where recieve_money.date BETWEEN "' . date("Y-m-d", strtotime('monday ' . $i . ' week ago')) . '" and "' . date("Y-m-d", strtotime('sunday ' . $i . ' week ago')) . '" and month(recieve_money.date)="' . date('m') . '" and  user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                $p_w[] = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where payment.date BETWEEN "' . date("Y-m-d", strtotime('monday ' . $i . ' week ago')) . '" and "' . date("Y-m-d", strtotime('sunday ' . $i . ' week ago')) . '" and month(payment.date)="' . date('m') . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                if ($i == 0) {
                    $label[] = "ທິດ " . ($s + 1);
                    $r_w[] = Yii::$app->db->createCommand('SELECT sum(amount)  FROM recieve_money LEFT JOIN user ON recieve_money.user_id=user.id where recieve_money.date BETWEEN "' . date("Y-m-d", strtotime('monday this week')) . '" and "' . date("Y-m-d", strtotime('sunday this week')) . '" and month(recieve_money.date)="' . date('m') . '" and  user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                    $p_w[] = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where payment.date BETWEEN "' . date("Y-m-d", strtotime('monday this week')) . '" and "' . date("Y-m-d", strtotime('sunday this week')) . '" and month(payment.date)="' . date('m') . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                }
            }
            $a_w = json_encode($p_w);
            $b_w = json_encode($r_w);

            /// for mount
            $amount_pay = array();
            $amount_recieve = array();
            for ($i = 1; $i <= 12; $i++) {
                $r = Yii::$app->db->createCommand('SELECT sum(amount)  FROM recieve_money LEFT JOIN user ON recieve_money.user_id=user.id where month(recieve_money.date)="' . $i . '" and year(recieve_money.date)="' . date('Y') . '" and  user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                $p = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where month(payment.date)="' . $i . '" and year(payment.date)="' . date('Y') . '" and  user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                $amount_recieve[] = $r;
                $amount_pay[] = $p;
            }
            $a = json_encode($amount_pay);
            $b = json_encode($amount_recieve);

            /// for Year
            $min_y = Yii::$app->db->createCommand('SELECT min(year(date))  FROM payment')->queryScalar();
            $max_y = Yii::$app->db->createCommand('SELECT max(year(date))  FROM payment')->queryScalar();

            $amount_y_pay = array();
            $amount_y_recieve = array();
            $label_y = array();
            for ($i = $min_y; $i <= $max_y; $i++) {
                $label_y[] = $i;
                $r_y = Yii::$app->db->createCommand('SELECT sum(amount)  FROM recieve_money LEFT JOIN user ON recieve_money.user_id=user.id where year(recieve_money.date)="' . $i . '" and  user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                $p_y = Yii::$app->db->createCommand('SELECT sum(amount)  FROM payment LEFT JOIN user ON payment.user_id=user.id where year(payment.date)="' . $i . '" and user.user_role_id=' . Yii::$app->session['user']->user_role_id . '')->queryScalar();
                $amount_y_recieve[] = $r_y;
                $amount_y_pay[] = $p_y;
            }
            $a_y = json_encode($amount_y_pay);
            $b_y = json_encode($amount_y_recieve);
            ?>
            <script>
                $(function () {
                    var areaChartData_y = {
                        labels:<?= json_encode($label_y) ?>,
                        datasets: [
                            {
                                label: "ລາຍ​ຮັບ",
                                fillColor: "rgba(60,141,188,0.9)",
                                strokeColor: "rgba(60,141,188,0.8)",
                                pointColor: "#3b8bba",
                                pointStrokeColor: "rgba(60,141,188,1)",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(60,141,188,1)",
                                data: <?= $b_y ?>
                            },
                            {
                                label: "ລາຍ​ຈ່າຍ",
                                fillColor: "rgba(210, 214, 222, 1)",
                                strokeColor: "rgba(210, 214, 222, 1)",
                                pointColor: "rgba(210, 214, 222, 1)",
                                pointStrokeColor: "#c1c7d1",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: <?= $a_y ?>
                            }

                        ]
                    };

                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas = $("#barChart_y").get(0).getContext("2d");
                    var barChart = new Chart(barChartCanvas);
                    var barChartData = areaChartData_y;
                    barChartData.datasets[0].fillColor = "#0c9a13";
                    barChartData.datasets[0].strokeColor = "#0c9a13";
                    barChartData.datasets[0].pointColor = "#0c9a13";

                    barChartData.datasets[1].fillColor = "#fd082b";
                    barChartData.datasets[1].strokeColor = "#fd082b";
                    barChartData.datasets[1].pointColor = "#fd082b";
                    var barChartOptions = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero: true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines: true,
                        //String - Colour of the grid lines
                        scaleGridLineColor: "rgba(0,0,0,.05)",
                        //Number - Width of the grid lines
                        scaleGridLineWidth: 1,
                        //Boolean - Whether to show horizontal lines (except X axis)
                        scaleShowHorizontalLines: true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines: true,
                        //Boolean - If there is a stroke on each bar
                        barShowStroke: true,
                        //Number - Pixel width of the bar stroke
                        barStrokeWidth: 2,
                        //Number - Spacing between each of the X value sets
                        barValueSpacing: 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing: 1,
                        //String - A legend template
                        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                        //Boolean - whether to make the chart responsive
                        responsive: true,
                        maintainAspectRatio: true
                    };

                    barChartOptions.datasetFill = false;
                    barChart.Bar(barChartData, barChartOptions);
                });
            </script>
            <script>
                $(function () {
                    var areaChartData_m = {
                        labels: <?= json_encode($label) ?>,
                        datasets: [
                            {
                                label: "ລາຍ​ຮັບ",
                                fillColor: "rgba(60,141,188,0.9)",
                                strokeColor: "rgba(60,141,188,0.8)",
                                pointColor: "#3b8bba",
                                pointStrokeColor: "rgba(60,141,188,1)",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(60,141,188,1)",
                                data: <?= $b_w ?>
                            },
                            {
                                label: "ລາຍ​ຈ່າຍ",
                                fillColor: "rgba(210, 214, 222, 1)",
                                strokeColor: "rgba(210, 214, 222, 1)",
                                pointColor: "rgba(210, 214, 222, 1)",
                                pointStrokeColor: "#c1c7d1",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: <?= $a_w ?>
                            }

                        ]
                    };

                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas = $("#barChart_m").get(0).getContext("2d");
                    var barChart = new Chart(barChartCanvas);
                    var barChartData = areaChartData_m;
                    barChartData.datasets[0].fillColor = "#0c9a13";
                    barChartData.datasets[0].strokeColor = "#0c9a13";
                    barChartData.datasets[0].pointColor = "#0c9a13";

                    barChartData.datasets[1].fillColor = "#fd082b";
                    barChartData.datasets[1].strokeColor = "#fd082b";
                    barChartData.datasets[1].pointColor = "#fd082b";
                    var barChartOptions = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero: true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines: true,
                        //String - Colour of the grid lines
                        scaleGridLineColor: "rgba(0,0,0,.05)",
                        //Number - Width of the grid lines
                        scaleGridLineWidth: 1,
                        //Boolean - Whether to show horizontal lines (except X axis)
                        scaleShowHorizontalLines: true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines: true,
                        //Boolean - If there is a stroke on each bar
                        barShowStroke: true,
                        //Number - Pixel width of the bar stroke
                        barStrokeWidth: 2,
                        //Number - Spacing between each of the X value sets
                        barValueSpacing: 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing: 1,
                        //String - A legend template
                        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                        //Boolean - whether to make the chart responsive
                        responsive: true,
                        maintainAspectRatio: true
                    };

                    barChartOptions.datasetFill = false;
                    barChart.Bar(barChartData, barChartOptions);
                });
            </script>
            <script>
                $(function () {
                    var areaChartData = {
                        labels: ["ເດືອນ 1", "ເດືອນ 2", "ເດືອນ 3", "ເດືອນ 4", "ເດືອນ 5", "ເດືອນ 6", "ເດືອນ 7", "ເດືອນ 8", "ເດືອນ 9", "ເດືອນ 10", "ເດືອນ 11", "ເດືອນ 12"],
                        datasets: [
                            {
                                label: "ລາຍ​ຮັບ",
                                fillColor: "rgba(60,141,188,0.9)",
                                strokeColor: "rgba(60,141,188,0.8)",
                                pointColor: "#3b8bba",
                                pointStrokeColor: "rgba(60,141,188,1)",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(60,141,188,1)",
                                data: <?= $b ?>
                            },
                            {
                                label: "ລາຍ​ຈ່າຍ",
                                fillColor: "rgba(210, 214, 222, 1)",
                                strokeColor: "rgba(210, 214, 222, 1)",
                                pointColor: "rgba(210, 214, 222, 1)",
                                pointStrokeColor: "#c1c7d1",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: <?= $a ?>
                            }

                        ]
                    };

                    //-------------
                    //- BAR CHART -
                    //-------------
                    var barChartCanvas = $("#barChart").get(0).getContext("2d");
                    var barChart = new Chart(barChartCanvas);
                    var barChartData = areaChartData;
                    barChartData.datasets[0].fillColor = "#0c9a13";
                    barChartData.datasets[0].strokeColor = "#0c9a13";
                    barChartData.datasets[0].pointColor = "#0c9a13";

                    barChartData.datasets[1].fillColor = "#fd082b";
                    barChartData.datasets[1].strokeColor = "#fd082b";
                    barChartData.datasets[1].pointColor = "#fd082b";
                    var barChartOptions = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero: true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines: true,
                        //String - Colour of the grid lines
                        scaleGridLineColor: "rgba(0,0,0,.05)",
                        //Number - Width of the grid lines
                        scaleGridLineWidth: 1,
                        //Boolean - Whether to show horizontal lines (except X axis)
                        scaleShowHorizontalLines: true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines: true,
                        //Boolean - If there is a stroke on each bar
                        barShowStroke: true,
                        //Number - Pixel width of the bar stroke
                        barStrokeWidth: 2,
                        //Number - Spacing between each of the X value sets
                        barValueSpacing: 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing: 1,
                        //String - A legend template
                        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                        //Boolean - whether to make the chart responsive
                        responsive: true,
                        maintainAspectRatio: true
                    };

                    barChartOptions.datasetFill = false;
                    barChart.Bar(barChartData, barChartOptions);
                });

            </script>
            <?php
        }
        ?>
    </body>
</html>
<?php $this->endPage() ?>
