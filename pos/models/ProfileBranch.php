<?php

namespace app\models;

use Yii;
use \app\models\base\ProfileBranch as BaseProfileBranch;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "profile_branch".
 */
class ProfileBranch extends BaseProfileBranch
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
