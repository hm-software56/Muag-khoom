<?php

namespace app\controllers;

use app\models\User;
use Yii;

class ApiLoginController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::find()->where(['username' => \Yii::$app->request->post('username')])->one();
        if (!$user || !Yii::$app->getSecurity()->validatePassword(\Yii::$app->request->post('password'), $user->password)) {
            $result=['login'=>'false','msg'=>'Incorrect username or password.'];
            return $result;
        } else {
            $result=array_merge(['login'=>'true',$user]);
            return $result;
        }
    }

}
