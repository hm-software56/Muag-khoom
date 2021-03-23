<?php
return function ($event) {
    try {
        $atkey = \app\models\ShopProfile::find()->one();
        \Yii::$app->session['profile'] = $atkey;
        $key = base64_decode(str_rot13($atkey->key_active));
        $key_acitvated = substr($key, 25, 2) . substr($key, 17, -8) . "-" . substr($key, 6, -19) . "-" . substr($key, 0, -25);
        \Yii::$app->session['key_acitvated'] = $key_acitvated;
        if (date('Y-m-d') > $key_acitvated) {
            if (!\Yii::$app->request->get('key') && !\Yii::$app->request->post('key')) {
                return Yii::$app->response->redirect(['site/login', 'key' => 1]);
            } elseif (\Yii::$app->request->post('key')) {
                $key = (int)\Yii::$app->request->post('key');
                $key_post = substr($key, 25, 2) . substr($key, 17, -8) . "-" . substr($key, 6, -19) . "-" . substr($key, 0, -25);
                if ($key == 0 || ($key != 0 and date('Y-m-d') <= $key_post)) {
                    \Yii::$app->session->set('error_keys', '1');
                    \Yii::$app->getSession()->setFlash('error_key', \Yii::t('app', 'Your key incorrect please try again.'));
                    return Yii::$app->response->redirect(['site/login', 'key' => 1]);

                } else {
                    $ky = str_rot13(base64_encode(\Yii::$app->request->post('key')));
                    Yii::$app->request->setBodyParams(['key' => $ky, '_csrf' => Yii::$app->request->getCsrfToken()]);
                }
            }
            \Yii::$app->session->set('error_keys', '');

        }
    } catch (\yii\db\Exception $exception) {
        #Use when install
        $try_m = 'last day of 2 month'; /// try to use 5 month
        $key_generate = date('dis') . date('m', strtotime("" . $try_m . "")) . mt_rand(100000000, 999999999) . date('y', strtotime("" . $try_m . "")) . date('his') . substr(date('Y', strtotime("" . $try_m . "")), 0, 2);
        \Yii::$app->session['key_install'] = str_rot13(base64_encode($key_generate));
        if ($exception->getCode() == 1049) {
            if (empty(Yii::$app->session->get('install'))) { # no database

                Yii::$app->session->set('install', true);
                echo \Yii::$app->response->redirect(['site/install'])->send();
                exit();
            }
        }

    }
};
?>
