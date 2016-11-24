<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recieve_money".
 *
 * @property integer $id
 * @property integer $amount
 * @property string $description
 * @property string $date
 * @property integer $tye_receive_id
 * @property integer $user_id
 *
 * @property TyeReceive $tyeReceive
 * @property User $user
 */
class RecieveMoney extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recieve_money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date', 'tye_receive_id', 'user_id'], 'required', 'message' => 'ທ່ານ​ຕ້ອງ​ປ້ອນ​ {attribute}'],
            [['tye_receive_id', 'user_id'], 'integer'],
            [['description', 'amount'], 'string'],
            [['date'], 'safe'],
            [['tye_receive_id'], 'exist', 'skipOnError' => true, 'targetClass' => TyeReceive::className(), 'targetAttribute' => ['tye_receive_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'ຈຳ​ນວເງີນ',
            'description' => '​ລາຍ​ລະ​ອຽດ​ທີ່​ຮັບ',
            'date' => 'ວັນ​ທີຮັບ',
            'tye_receive_id' => '​ປະ​ເພດ​ລາຍ​ຮັບ',
            'user_id' => 'ຜູ້​ໃຊ້',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTyeReceive()
    {
        return $this->hasOne(TyeReceive::className(), ['id' => 'tye_receive_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        $this->amount = substr(preg_replace('/\D/', '', $this->amount), 0, -2);
        return parent::beforeSave($insert);
    }

}
