<?php

namespace app\models;

use Yii;
use \app\models\base\ProductTransfer as BaseProductTransfer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_transfer".
 */
class ProductTransfer extends BaseProductTransfer
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
