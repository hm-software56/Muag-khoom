<?php

/**
 * @copyright Copyright &copy; Giulio Ganci
 * @package yii2-widgets
 * @subpackage yii2-widget-lazyload
 * @version 1.0
 */

namespace toriphes\lazyload;

use yii\web\AssetBundle;

/**
 * LazyLoad Asset
 *
 * @author: Giulio Ganci <giulioganci@gmail.com>
 * @see https://github.com/tuupola/jquery_lazyload
 * @since 1.0
 */
class LazyloadAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.lazyload';

    public $js = [
        'jquery.lazyload.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}