<?php

namespace app\models;

use Yii;
use \app\models\base\Branch as BaseBranch;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "branch".
 */
class Branch extends BaseBranch
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
