<?php

namespace app\models;

use Yii;
use \app\models\base\Purchase as BasePurchase;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "purchase".
 */
class Purchase extends BasePurchase
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
