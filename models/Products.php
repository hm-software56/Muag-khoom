<?php

namespace app\models;

use Yii;
use \app\models\base\Products as BaseProducts;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "products".
 */
class Products extends BaseProducts {

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
                    [['pricesale', 'pricebuy'], 'string', 'max' => 255],
                        ]
        );
    }

    public function attributeLabels() {
        return ArrayHelper::merge(
                        parent::rules(), [
                    'id' => 'ລະ​ຫັດ',
                    'name' => '​ຊື່ສ​ີນ​ຄ້າ',
                    'qautity' => 'ຈຳ​ນວນ',
                    'date' => '​ວັນ​ທີ່',
                    'pricesale' => 'ລາ​ຄາ​ຂາຍ​',
                    'pricebuy' => '​ລາ​ຄາ​ຊື້',
                    'image' => 'ຮູບ​ພາບ',
                    'category_id' => 'ໜວດ​ສີນ​ຄ້າ',
                    'user_id' => 'ຜູ້​ປ້ອນ​ເຂົ້າ',
                        ]
        );
    }

    public function beforeSave($insert) {
        $this->pricesale = substr(preg_replace('/\D/', '', $this->pricesale), 0, -2);
        $this->pricebuy = substr(preg_replace('/\D/', '', $this->pricebuy), 0, -2);
        return parent::beforeSave($insert);
    }

}
