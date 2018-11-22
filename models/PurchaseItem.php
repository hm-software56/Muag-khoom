<?php

namespace app\models;

use Yii;
use \app\models\base\PurchaseItem as BasePurchaseItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "purchase_item".
 */
class PurchaseItem extends BasePurchaseItem
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
