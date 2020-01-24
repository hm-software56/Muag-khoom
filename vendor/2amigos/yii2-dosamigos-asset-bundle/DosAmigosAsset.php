<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\assets;

use yii\web\AssetBundle;

/**
 * DosAmigosAsset
 *
 * The main purpose of this asset bundle is to include utility javascript files and extra assets that may be shared
 * among projects.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\assets
 */
class DosAmigosAsset extends AssetBundle
{
    public $sourcePath = '@vendor/2amigos/yii2-dosamigos-asset-bundle/assets';

    public $js = [
        'js/dosamigos.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}