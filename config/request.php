<?php
return function ($event) {
    $atkey = \app\models\ShopProfile::find()->one();
    \Yii::$app->session['profile'] = $atkey;
    $key = $atkey->key_active;
    $key_acitvated = substr($key, 25, 2) . substr($key, 17, -8) . "-" . substr($key, 6, -19) . "-" . substr($key, 0, -25);
    \Yii::$app->session['key_acitvated'] = $key_acitvated;
    if (date('Y-m-d') > $key_acitvated) {
        if (!\Yii::$app->request->get('key') && !\Yii::$app->request->post('key')) {
            return Yii::$app->response->redirect(['site/login', 'key' => 1]);
        } elseif (\Yii::$app->request->post('key')) {
            $key = (int)\Yii::$app->request->post('key');
            $key_post = substr($key, 25, 2) . substr($key, 17, -8) . "-" . substr($key, 6, -19) . "-" . substr($key, 0, -25);
            if ($key == 0 || ($key != 0 and date('Y-m-d') <= $key_post)) {
                \Yii::$app->session->set('error_keys','1');
                \Yii::$app->getSession()->setFlash('error_key', \Yii::t('app', 'Your key incorrect please try again.'));
                return Yii::$app->response->redirect(['site/login', 'key' => 1]);

            }
        }
        \Yii::$app->session->set('error_keys','');

    }
    #echo \Yii::$app->session['key_acitvated'];exit;
};
?>
