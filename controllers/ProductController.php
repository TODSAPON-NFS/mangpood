<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Category;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ProductController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'view', 'update', 'delete', 'deleteall', 'productidsuggestion', 'productnamesuggestion'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'deleteall', 'productidsuggestion', 'productnamesuggestion'],
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
        $searchModel = new ProductSearch();
        $model = new Product(); //<== เพิ่มตรงนี้
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionView($id) {

        $modelCategory = new Category();
        $model = $this->findModel($id);

        $modelCategoryQuery = $modelCategory->find()->where(['category_id' => $model->category_id])->one();

        return $this->render('view', [
                    'model' => $model,
                    'modelCategory' => $modelCategoryQuery,
        ]);
    }

    public function actionCreate() {
        $model = new Product();

        //Ajax Validation อย่าลืมไปเพิ่ม 'enableAjaxValidation' => true, ใน ActiveForm::begin([]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (empty($model->product_code)) {
                $model->product_code = '' . $model->product_id . '';
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        //Ajax Validation อย่าลืมไปเพิ่ม 'enableAjaxValidation' => true, ใน ActiveForm::begin([]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (empty($model->product_code)) {
                $model->product_code = '' . $model->product_id . '';
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete() { // <== แก้ตรงนี้
        if (Yii::$app->request->post('id')) {

            $id = Yii::$app->request->post('id');
            $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

    //ลบแบบเลือกหลายรายการ
    public function actionDeleteall() {

        if (Yii::$app->request->post('ids')) {

            $delete_multiple_id = explode(',', Yii::$app->request->post('ids'));
            Product::deleteAll(['in', 'product_id', $delete_multiple_id]); //<== เพิ่ม + แก้ตรงนี้
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionProductidsuggestion() {

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = Product::find()->select(['product_code', 'product_name', 'product_price', 'product_wholesale_price', 'product_weight'])->where(['like', 'product_code', $q])->asArray()->all();

        foreach ($suggestion as $key => $value) {

            $array[$key]['label'] = 'รหัส:' . $value['product_code'] . ', ' . $value['product_name'] . ', ' . $value['product_price'] . ' บาท';
            $array[$key]['value'] = $value['product_code'];
            $array[$key]['name'] = $value['product_name'];
            $array[$key]['price'] = $value['product_price'];
            $array[$key]['wholesaleprice'] = $value['product_wholesale_price'];
            $array[$key]['weight'] = $value['product_weight'];

        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

    public function actionProductnamesuggestion() {

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = Product::find()->select(['product_code', 'product_name', 'product_price', 'product_weight', 'product_wholesale_price'])->where(['like', 'product_name', $q])->asArray()->all();

        foreach ($suggestion as $key => $value) {
            $array[$key]['label'] = 'รหัส:' . $value['product_code'] . ', ' . $value['product_name'] . ', ' . $value['product_price'] . ' บาท';
            $array[$key]['value'] = $value['product_name'];
            $array[$key]['code'] = $value['product_code'];
            $array[$key]['price'] = $value['product_price'];
            $array[$key]['wholesaleprice'] = $value['product_wholesale_price'];
            $array[$key]['weight'] = $value['product_weight'];
        }

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

}
