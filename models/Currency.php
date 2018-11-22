<?php

namespace app\models;

use Yii;
use \app\models\base\Currency as BaseCurrency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currency".
 */
class Currency extends BaseCurrency
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
