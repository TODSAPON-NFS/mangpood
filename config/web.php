<?php

$params = require(__DIR__ . '/params.php');

/* == แปลงผลลัพธ์ของ getBaseUrl() คือ /mangpood/web ส่วนไหนที่เป็น /web ให้แทนที่ด้วยค่าว่าง จะได้ /mangpood เฉยๆ == */

use \yii\web\Request;

$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

$config = [
    'language' => 'th', //ตั้งค่าภาษาไทย
    'timezone' => 'Asia/Bangkok', //ตั้งค่า TimeZone
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wP8VkN7LFgHnI2XdBYxElq7WbSstvu8a',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=mangpood',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false, //แสดง index.php ขึ้นมาเป็นไดเรกทอรีหนึ่ง
            'enableStrictParsing' => false,
        //'suffix' => '.html', //เติมนามสกุลให้ไฟล์
        ],
        'thaiFormatter' => [
            'class' => 'dixonsatit\thaiYearFormatter\ThaiYearFormatter',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) { // <== ถ้าพัฒนาเสร็จแล้ว แก้ YII_ENV_DEV เป็น YII_ENV_PROD แทน
// configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
