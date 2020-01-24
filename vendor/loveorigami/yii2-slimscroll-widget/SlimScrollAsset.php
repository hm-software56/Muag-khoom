<?php
namespace lo\widgets;

use yii\web\AssetBundle;

/**
 * SlimScroll asset class
 * @package lo\widgets
 */
class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-slimscroll';
    public $js = [
        'jquery.slimscroll.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
