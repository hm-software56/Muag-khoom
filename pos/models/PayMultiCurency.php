<?php

namespace app\models;

use Yii;
use \app\models\base\PayMultiCurency as BasePayMultiCurency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pay_multi_curency".
 */
class PayMultiCurency extends BasePayMultiCurency
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
