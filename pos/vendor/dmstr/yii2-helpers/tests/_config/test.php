<?php
/**
 * Application configuration for unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../../../src/config/main.php'),
    [
        'controllerNamespace' => 'app\controllers',
    ]
);
