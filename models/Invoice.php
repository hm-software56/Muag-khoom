<?php

namespace app\models;

use Yii;
use \app\models\base\Invoice as BaseInvoice;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "invoice".
 */
class Invoice extends BaseInvoice {

    public function behaviors() {
        return ArrayHelper::merge(
                        parent::behaviors(), [
                        # custom behaviors
                        ]
        );
    }

    public function rules() {
        return ArrayHelper::merge(
                        parent::rules(), [
                        # custom validation rules
                        ]
        );
    }

}
