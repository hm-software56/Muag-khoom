<?php

/**
 * @copyright Copyright &copy; Giulio Ganci
 * @package yii2-widgets
 * @subpackage yii2-widget-lazyload
 * @version 1.0
 */

namespace toriphes\lazyload;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Wrapper for jquery.lazyload jquery plugin
 *
 * @author: Giulio Ganci <giulioganci@gmail.com>
 * @see https://github.com/tuupola/jquery_lazyload
 * @since 1.0
 */
class LazyLoad extends Widget
{
    /**
     * @var string $src the image src attribute
     */
    public $src;

    /**
     * @var array $options the HTML attributes for the img tag
     */
    public $options;

    /**
     * @var array $clientOptions options for the jquery.lazyload.js plugin
     * @see http://www.appelsiini.net/projects/lazyload
     */
    public $clientOptions = [];

    /**
     * @var string $cssClass the css class to be applied to each img tag
     */
    public $cssClass = 'lazy';

    /**
     * @var bool $fallback if you want to support non JavaScript users
     * @see http://www.appelsiini.net/projects/lazyload#fallback-for-non-javascript-browsers
     */
    public $fallback = false;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if(empty($this->src)) {
            throw new InvalidConfigException("You must set the 'src' property");
        }

        $this->options['data-original'] = $this->src;

        if(isset($this->options['class']) && !empty($this->options['class'])) {
            $this->options['class'] .= " $this->cssClass";
        } else {
            $this->options['class'] = $this->cssClass;
        }

        if(isset($this->options['src'])) {
            unset($this->options['src']);
        }

        $this->registerClientScript();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::tag('img', '', $this->options);
        if($this->fallback) {
            $options = $this->options;
            ArrayHelper::remove($options, 'data-original');
            echo '<noscript>';
            echo Html::img($this->src, $options);
            echo '</noscript>';
        }
    }

    /**
     * Registers the jquery.lazyload plugin
     */
    public function registerClientScript()
    {
        $this->clientOptions = ArrayHelper::merge(
            $this->clientOptions,
            [
                'failurelimit' => 10,
                'effect' => 'fadeIn',
            ]
        );

        $clientOptions = Json::encode($this->clientOptions);
        $selector = 'img.'.$this->cssClass;

        LazyloadAsset::register($this->view);

        $this->view->registerJs("$('$selector').lazyload($clientOptions);");

        if($this->fallback) {
            $this->view->registerCss($selector.'{display:none}');
        }
    }
}
