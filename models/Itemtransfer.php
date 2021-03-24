<?php

namespace app\models;

use Yii;
use \app\models\base\Itemtransfer as BaseItemtransfer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "item_transfer".
 */
class Itemtransfer extends BaseItemtransfer
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
