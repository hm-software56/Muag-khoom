<?php

namespace app\models;

use Yii;
use \app\models\base\ShopProfile as BaseShopProfile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "shop_profile".
 */
class ShopProfile extends BaseShopProfile
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
