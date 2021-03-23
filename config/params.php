<?php

return [
    'version' => Yii::t('app', 'Version:1.3'),
    'email' => 'daxionginfo@gmail.com',
    'phone' => '020 55045770',
    'adminEmail' => 'admin@example.com',
    'timeout' => @date('dHi') + 120,
    'alert_date' => '10 day',
    'height_disable' => 450, //this hieght size not show in mobile
    'width_disable' => 450,//this width size not show in mobile
    #'url_display_client_pos' => yii\helpers\Url::base(true) .'/index.php?r=products/displayclientorder',
    'enable_display_client_pos' => false,

];
