<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PipelineForm;
use yii\filters\AccessControl;

class PipelineController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'view', 'update', 'delete', 'deleteall', 'pipeline'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'deleteall', 'pipeline'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'deleteall' => ['POST'],
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

        return $this->render("index", [
                    'model' => $model,
        ]);
    }

    public function actionCreate() {
        $model = new PipelineForm();

        //Ajax Validation อย่าลืมไปเพิ่ม 'enableAjaxValidation' => true, ใน ActiveForm::begin([]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->category_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
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
                
                print_r($model);

                echo "เรียบร้อยจ้าx";   

            } else {
                
                return $this->render('create', [
                'model' => $model,
                    ]);
                
            }
        } else {
            echo "ติดตรงนี้ 2x";
        }
    }
    
    public function actionPipelineajaxmultiply() {
        $q1 = trim(Yii::$app->request->get("q1"));
        $q2 = trim(Yii::$app->request->get("q2"));
        return $q1*$q2;
    }

}
