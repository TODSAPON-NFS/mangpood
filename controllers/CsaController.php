<?php

namespace app\controllers;

use Yii;
use app\models\Csa;
use app\models\District;
use app\models\Subdistrict;
use app\models\Province;
use app\models\CsaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CsaController extends Controller {
    
        public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','view','update','delete','deleteall','district','subdistrict','zipcode','namesuggestion','emailsuggestion','provincesuggestion','subdistrictsuggestion','districtsuggestion'],
                'rules' => [
                    [
                        'actions' => ['index','create','view','update','delete','deleteall','district','subdistrict','zipcode','namesuggestion','emailsuggestion','provincesuggestion','subdistrictsuggestion','districtsuggestion'],
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
        $searchModel = new CsaSearch();
        $model = new Csa(); //<== เพิ่มตรงนี้
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate() {
        $model = new Csa();

        //Ajax Validation อย่าลืมไปเพิ่ม 'enableAjaxValidation' => true, ใน ActiveForm::begin([]);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {

            //เติมคำว่า "คุณ" เข้าไปข้างหน้า
            $model->csa_name_surname = (strpos($model->csa_name_surname, 'คุณ') === 0) ? $model->csa_name_surname : 'คุณ' . $model->csa_name_surname;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->csa_id]);
            }
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
            return $this->redirect(['view', 'id' => $model->csa_id]);
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
            Csa::deleteAll(['in', 'csa_id', $delete_multiple_id]); //<== เพิ่ม + แก้ตรงนี้
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Csa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /* === ข้างล่างเพิ่มเอง === */

    public function actionDistrict() {

        $province_id = Yii::$app->request->post("province_id");

        $districtQuery = District::find()->where(["province_id" => $province_id])->orderBy(["district_name" => SORT_ASC])->asArray()->all();

        echo '<option value="">เลือกอำเภอ / เขต</option>';

        foreach ($districtQuery as $value) {
            echo '<option value="' . $value['district_id'] . '">' . $value['district_name'] . '</option>';
        }
    }

    public function actionSubdistrict() {

        $district_id = trim(Yii::$app->request->post("district_id"));

        $subdistrictQuery = Subdistrict::find()->where(["district_id" => $district_id])->asArray()->orderBy('subdistrict_name')->all();

        echo '<option value="">เลือกตำบล / แขวง</option>';

        foreach ($subdistrictQuery as $value) {
                echo '<option value="' . $value['subdistrict_id'] . '">'.$value['subdistrict_name'].'</option>';
        }
    }

    public function actionZipcode() {

        $subdistrict_id = trim(Yii::$app->request->post("subdistrict_id"));

        if (empty($subdistrict_id)) {
            echo "";
        } else {
            $zipcodeQuery = Subdistrict::find()->where(["subdistrict_id" => $subdistrict_id])->orderBy('subdistrict_name')->one();

            echo $zipcodeQuery->subdistrict_zipcode;
        }
    }

    public function actionNamesuggestion() {

        $model = new Csa();

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = Csa::find()->where(['like', 'csa_name_surname', $q])->asArray()->all();

        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return $suggestion;

        foreach ($suggestion as $key => $value) {
            $array[$key]['label'] = $value['csa_name_surname'] . ' (' . $value['csa_email'] . ' ' . $value['csa_phone'] . ' ' . $model::provinceNameRequest($value['csa_province_id']) . ')';
            $array[$key]['value'] = $value['csa_name_surname'];
            $array[$key]['id'] = $value['csa_id'];
            $array[$key]['address'] = $value['csa_address'];
            $array[$key]['phone'] = $value['csa_phone'];
            $array[$key]['email'] = $value['csa_email'];
            $array[$key]['province'] = $model::provinceNameRequest($value['csa_province_id']);
            $array[$key]['district'] = $model::districtNameRequest($value['csa_district_id']);
            $array[$key]['subdistrict'] = $model::subdistrictNameRequest($value['csa_subdistrict_id']);
            $array[$key]['zipcode'] = $value['csa_zipcode'];
            $array[$key]['note'] = $value['csa_note'];
            $array[$key]['socialmedia'] = $value['csa_socialmedia'];
            $array[$key]['company'] = $value['csa_company'];
            $array[$key]['type'] = $value['csa_type'];
        }

        //print_r($array);
        //echo "<br /><br />";
        //echo json_encode($array, JSON_UNESCAPED_UNICODE);

        return json_encode($array, JSON_UNESCAPED_UNICODE);
    }

    public function actionEmailsuggestion() {

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = Csa::find()->select(['csa_email as value', 'csa_email as label'])->where(['like', 'csa_email', $q])->asArray()->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $suggestion;
    }

    public function actionProvincesuggestion() {

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = Province::find()->select(['province_name as value', 'province_name as label'])->where(['like', 'province_name', $q])->asArray()->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $suggestion;
    }

    public function actionSubdistrictsuggestion() {

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = Subdistrict::find()->select(['subdistrict_name as value', 'subdistrict_name as label'])->distinct()->where(['like', 'subdistrict_name', $q])->asArray()->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $suggestion;
    }
    
    public function actionDistrictsuggestion() {

        $q = trim(Yii::$app->request->get("q"));

        $suggestion = District::find()->select(['district_name as value', 'district_name as label'])->distinct()->where(['like', 'district_name', $q])->asArray()->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $suggestion;
    }

}
