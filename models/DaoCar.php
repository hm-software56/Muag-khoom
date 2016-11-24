<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dao_car".
 *
 * @property integer $id
 * @property integer $amount
 * @property string $date
 * @property string $status
 * @property string $remark
 */
class DaoCar extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dao_car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date', 'status'], 'required', 'message' => 'ທ່ານ​ຕ້ອງ​ປ້ອນ​ {attribute}'],
            //  [['amount'], 'integer'],
            [['date'], 'safe'],
            [['status', 'remark', 'amount'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ລະ​ຫັດ',
            'amount' => '​ຈຳ​ນວນ​ເງີນ',
            'date' => '​ວັນ​ທີ',
            'status' => '​ສະ​ຖາ​ນະ',
            'remark' => '​ໝາຍ​ເຫດ',
        ];
    }

}
