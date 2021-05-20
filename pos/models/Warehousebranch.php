<?php

namespace app\models;

use Yii;
use \app\models\base\Warehousebranch as BaseWarehousebranch;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "warehouse_branch".
 */
class Warehousebranch extends BaseWarehousebranch
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
