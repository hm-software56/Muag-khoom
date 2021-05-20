<?php
namespace lo\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class SlimScroll extends \yii\base\Widget
{

   /**
     * SlimScroll options
     * @link http://rocha.la/jQuery-slimScroll
     * @var array()
    *
     */
    public $options =[];
    private static $default=[
        'height' => '350px',

        //'width'=> '250px',
        //'size' => '10px',
        //'position' => 'left',
        //'color' => '#ffcc00',
        //'distance' => '20px',
        //'start' => '$('#child_image_element')',

        'alwaysVisible' => true,
        'railVisible' => true,
        'railColor' => '#222',
        'railOpacity' => '0.3',
        'wheelStep' => 10,
        'allowPageScroll' => true,
        'disableFadeOut' => false
    ];

    /**
     * Tag Html attributes
     * @var array()
     */
    public $htmlOptions=[];

    /**
     * Tag
     * @var string
     */
    public static $tag = 'div';

    public function init()
    {
        parent::init();

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->id;
        } else {
            $this->id = $this->htmlOptions['id'];
        }

        $this->htmlOptions['id'] .= '-slim';
    }


    /**
     * Generates a start tag and registers SlimScroll.
     * @see \yii\helpers\BaseHtml::beginTag()
     * @param array() $config
     * @return string
     */
    public function run()
    {
        $view = $this->getView();
        SlimScrollAsset::register($view);
        $options = Json::encode(ArrayHelper::merge(self::$default, $this->options));
        $view->registerJs("jQuery('#{$this->htmlOptions['id']}').slimScroll($options);");

        return Html::beginTag(self::$tag, $this->htmlOptions);
    }

    /**
     * Generates an end tag.
     * @see \yii\helpers\BaseHtml::endTag()
     * @return string
     */
    public static function end()
    {
        return Html::endTag(self::$tag);
    }

}
