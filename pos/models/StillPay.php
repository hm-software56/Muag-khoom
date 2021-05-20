<?php

namespace app\models;

use Yii;
use \app\models\base\StillPay as BaseStillPay;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "still_pay".
 */
class StillPay extends BaseStillPay
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

    public static function details($id){
        $stillpay=\app\models\StillPay::find()->where(['id'=>$id])->one();
        if ($stillpay->custommer_id !=0) {
            if($stillpay->name!=1)
            {
                $detais="<div style='color:red;'>".$stillpay->custommer->name." <b>(".$stillpay->name.")</b></div>";
            }else{
                $detais="<div style='color:red;'>".$stillpay->custommer->name."</div>";
            }
           
        }else{
            $detais="<div style='color:red;'>".$stillpay->name."</div>";
        }
        $detais.= "<div>" . $stillpay->details . "</div>";
		$detais.= "<div style='color:green;'>" . number_format($stillpay->price,2) . " ກີບ</div>";
        $detais .= "<div>" . $stillpay->date . "</div>";
        return $detais;
    }
    public function beforeSave($insert)
    {
        $this->price = substr(preg_replace('/\D/', '', $this->price), 0, -2);
        return parent::beforeSave($insert);
    }
}
