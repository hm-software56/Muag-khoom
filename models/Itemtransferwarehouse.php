<?php

namespace app\models;

use Yii;
use \app\models\base\Itemtransferwarehouse as BaseItemtransferwarehouse;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "item_transfer_to_warehouse".
 */
class Itemtransferwarehouse extends BaseItemtransferwarehouse
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
