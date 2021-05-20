<?php
namespace yii2assets\printthis;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class PrintThis extends Widget
{
    public $options = [];
    public $htmlOptions = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if(isset($this->htmlOptions['id'])){
            $this->id = $this->htmlOptions['id'];
        }else{
            $this->id = $this->htmlOptions['id'] = $this->getId();
        }

        echo Html::button('<i class="'.$this->htmlOptions['btnIcon'].'"></i> '.$this->htmlOptions['btnText'].'', ['class' => ''.$this->htmlOptions['btnClass'].'', 'id' => ''.$this->htmlOptions['btnId'].'']);

        $this->registerAsset();
        parent::run();

    }

    protected function registerAsset()
    {
        PrintThisAsset::register($this->view);


        $jsOptions = Json::encode($this->options);
        $js = "$(\"#".$this->htmlOptions['btnId']."\").click(function(){
              $(\"#".$this->id."\").printThis(".$jsOptions.");
          });
          ";

        $key = __CLASS__ . '#' . $this->id;

        $this->view->registerJs($js, View::POS_READY, $key);

    }
}
