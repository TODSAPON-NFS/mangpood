<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Category;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'deleteall' => ['POST'],
                ],
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

}
