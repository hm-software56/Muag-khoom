<?php

namespace app\models;

use Yii;
use \app\models\base\Discount as BaseDiscount;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "discount".
 */
class Discount extends BaseDiscount
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
