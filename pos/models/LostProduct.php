<?php

namespace app\models;

use Yii;
use \app\models\base\LostProduct as BaseLostProduct;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "lost_product".
 */
class LostProduct extends BaseLostProduct
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
