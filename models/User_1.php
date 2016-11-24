<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $photo
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $user_type
 * @property string $date
 *
 * @property Payment[] $payments
 * @property RecieveMoney[] $recieveMoneys
 */
class User extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'username', 'password', 'user_type', 'date'], 'required'],
            [['status'], 'integer'],
            [['user_type'], 'string'],
            [['date'], 'safe'],
            [['photo'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 10 * 1024, 'tooBig' => 'ຮູບ​ພາບ​ຂອງ​ທ່ານບໍ່​ໃຫ້​ເກີນ 10Kb.'],
            [['first_name', 'last_name', 'username', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'password' => 'Password',
            'status' => 'Status',
            'user_type' => 'User Type',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecieveMoneys()
    {
        return $this->hasMany(RecieveMoney::className(), ['user_id' => 'id']);
    }

}
