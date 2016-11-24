<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'fontawesome/css/font-awesome.min.css',
        //'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'adminlte/dist/css/AdminLTE.min.css',
        'adminlte/dist/css/skins/_all-skins.min.css',
        // 'adminlte/plugins/iCheck/flat/blue.css',
        'adminlte/bootstrap/css/bootstrap.css',
            // 'adminlte/plugins/morris/morris.css',
            //  'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
            // 'adminlte/plugins/datepicker/datepicker3.css',
            // 'adminlte/plugins/daterangepicker/daterangepicker.css',
            //  'adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    ];
    public $js = [
        //  'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js', //
        //   'adminlte/plugins/morris/morris.min.js',
        // 'adminlte/plugins/sparkline/jquery.sparkline.min.js',
        // 'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        //  'adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'adminlte/plugins/knob/jquery.knob.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js', //
        // 'adminlte/plugins/daterangepicker/daterangepicker.js', //
        // 'adminlte/plugins/datepicker/bootstrap-datepicker.js', //
        'adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        // 'adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
        //  'adminlte/plugins/fastclick/fastclick.js',
        'adminlte/dist/js/app.min.js',
        // 'adminlte/dist/js/pages/dashboard.js', //
        // 'adminlte/bootstrap/js/bootstrap.min.js', //
        //'adminlte/dist/js/demo.js', //
        // 'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js', //
        'autonumber/autoNumeric.js',
        'adminlte/plugins/chartjs/Chart.min.js',
            // 'adminlte/plugins/fastclick/fastclick.js',
            // 'adminlte/dist/js/app.min.js',
            // 'adminlte/dist/js/demo.js',
            //   "https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js",
            //  "//ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
