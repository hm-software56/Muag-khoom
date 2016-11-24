<?php

namespace app\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;

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
 * @property integer $user_role_id
 *
 * @property Payment[] $payments
 * @property RecieveMoney[] $recieveMoneys
 * @property UserRole $userRole
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

    public $photo_crop;
    public $photo_cropped;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'username', 'password', 'user_type', 'date', 'user_role_id'], 'required', 'message' => 'ຕ້ອງ​ປ້ອນ {attribute}'],
            [['status', 'user_role_id'], 'integer'],
            [['user_type'], 'string'],
            [['date'], 'safe'],
            // [['photo'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 100000 * 1024, 'tooBig' => 'ຮູບ​ພາບ​ຂອງ​ທ່ານບໍ່​ໃຫ້​ເກີນ 10Kb.'],
            ['photo', 'file', 'extensions' => 'jpeg, gif, png', 'on' => ['insert', 'update']],
            [['first_name', 'last_name', 'username'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 4, 'max' => 256, 'tooShort' => 'ລະ​ຫັດ​ຜ່ານຢ່າງ​ໜ້ອຍ​ຕ້ອງ​ມີ 4 ໂຕ​ຂື້ນ​ໄປ'],
            ['username', 'unique', 'message' => "ຊື່​ນີ້​ມີຜູ້​ໃຊ້​ແລ້ວ​ທ່ານ​ປ່ຽນ​ຊື່ໃໝ່."],
            [['user_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::className(), 'targetAttribute' => ['user_role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'photo' => 'ຮູບ​ພາບ',
            'first_name' => 'ຊື່',
            'last_name' => 'ນາມ​ສະ​ກຸນ',
            'username' => '​ຊື່​ເຂົ້າ​ລະ​ບົບ',
            'password' => '​ລະ​ຫັດ​ຜ່ານ',
            'status' => '​ສະ​ຖາ​ນະ',
            'user_type' => 'ສິດ​ເຂົ້າ​ລະ​ບົບ',
            'date' => '​ວັນ​ທີ',
            'user_role_id' => 'User Role ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserRole::className(), ['id' => 'user_role_id']);
    }

}
