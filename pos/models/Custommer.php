<?php

namespace app\models;

use Yii;
use \app\models\base\Custommer as BaseCustommer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "custommer".
 */
class Custommer extends BaseCustommer
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
