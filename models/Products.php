<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property integer $qautity
 * @property string $date
 * @property string $code
 * @property integer $pricesale
 * @property integer $pricebuy
 * @property string $image
 *
 * @property Sale[] $sales
 */
class Products extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'qautity', 'code', 'pricesale', 'pricebuy'], 'required'],
            [['qautity'], 'integer'],
            [['date'], 'safe'],
            [['name', 'pricesale', 'pricebuy'], 'string', 'max' => 255],
            [['code', 'image'], 'string', 'max' => 45],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'ຊື່​ສີ້ນ​ຄ້າ',
            'qautity' => '​ຈຳ​ນວນ',
            'date' => '​ວັນ​ທີ',
            'code' => '​ລະ​ຫັດ​ສີ້ນ​ຄ້າ',
            'pricesale' => '​ລາ​ຄາ​ຂາຍ',
            'pricebuy' => '​ລາ​ຄາ​ຊື້',
            'image' => '​ຮູບ​ພາບ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSales() {
        return $this->hasMany(Sale::className(), ['products_id' => 'id']);
    }

    public function beforeSave($insert) {
        $this->pricesale = substr(preg_replace('/\D/', '', $this->pricesale), 0, -2);
        $this->pricebuy = substr(preg_replace('/\D/', '', $this->pricebuy), 0, -2);
        return parent::beforeSave($insert);
    }

}
