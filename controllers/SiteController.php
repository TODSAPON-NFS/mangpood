<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
//use app\models\User;
use app\models\PipelineForm;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {

        $model = new PipelineForm();

        if (Yii::$app->user->isGuest) {
            return Yii::$app->runAction('site/login');
        } else {
            return $this->render("index", [
                        'modelPipeline' => $model,
            ]);
        }
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(); //สร้าง Instance loginForm (Model) ขึ้นมา

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    public function actionAbout() {
        return $this->render('about');
    }

//เข้าโหมด Reset ค่า Auto Increment ของตารางให้เป็น 1

    public function actionReset() {

        $table = trim(Yii::$app->request->get("table"));

        $sql = "ALTER TABLE {$table} AUTO_INCREMENT = 1";

        Yii::$app->db->createCommand($sql)->execute();

        echo "Reset Auto Increment ตาราง <strong>" . $table . "</strong> เสร็จแล้ว";
    }

    public function actionPipeline() {

//$model = Yii::$app->request->post();
//echo $model["PipelineForm"]["csa_name_surname"];

        $model = new PipelineForm();

        //Ajax Validation อย่าลืมไปเพิ่ม 'enableAjaxValidation' => true, ใน ActiveForm::begin([]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                echo "เรียบร้อยจ้า";
            } else {
                echo "ติดตรงนี้ 1";
            }
        } else {
            echo "ติดตรงนี้ 2";
        }
    }

}
