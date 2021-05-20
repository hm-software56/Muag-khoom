<?php

namespace app\models;

use Yii;
use \app\models\base\Barcode as BaseBarcode;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "barcode".
 */
class Barcode extends BaseBarcode
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
