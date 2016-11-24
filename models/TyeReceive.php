<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tye_receive".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 *
 * @property RecieveMoney[] $recieveMoneys
 */
class TyeReceive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tye_receive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sort' => 'Sort',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecieveMoneys()
    {
        return $this->hasMany(RecieveMoney::className(), ['tye_receive_id' => 'id']);
    }
}
