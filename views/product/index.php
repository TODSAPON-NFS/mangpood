<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สินค้า';
$this->params['breadcrumbs'][] = $this->title;

/* ลบทีละหลายรายการ */
$this->registerJs('
    
    $("#btnDeleteAll").click(function(){
            var keys = $("#productGridView").yiiGridView("getSelectedRows");
    
            if(!keys.length){
            
                bootbox.dialog({
                  message: "โปรดเลือกอย่างน้อย 1 รายการ",
                  title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\" style=\"color:#f0ad4e;\"></i> พบข้อผิดพลาด",
                  buttons: {
                    success: {
                      label: "ตกลง",
                      className: "btn-default",
                      callback: function() {}
                      }
                  }
                });
            }

            else{

            bootbox.dialog({
                  message: "โปรดเลือก <span class=\"label label-danger\">ลบข้อมูล</span> เพื่อยืนยันการลบรายการ หรือเลือก <span class=\"label label-default\">ปิด</span> เพื่อยกเลิกการลบข้อมูล",
                  title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\" style=\"color:#d9534f;\"></i> ยืนยันการลบข้อมูล",
                  buttons: {
                    success: {
                      label: "ลบข้อมูล",
                      className: "btn-danger",
                      callback: function() {
                            $.post("' . Url::toRoute([$model::CONTROLLER_ACTION_DELETEALL]) . '",{ids:keys.join()});
                        },
                      },
                    close: {
                        label: "ปิด",
                        className: "btn-default",
                        callback: function() {},
                    },
                  }
                });

            }

        });
', \yii\web\View::POS_READY);

/* ลบทีละ 1 รายการ */
$this->registerJs('

$(document).on("click", "#btnDeleteOne", function(event){
    
    event.preventDefault();
    var var_id = $(this).data("id");
    var var_name = $(this).data("name");
    
    bootbox.dialog({
         message: "โปรดเลือก <span class=\"label label-danger\">ลบข้อมูล</span> เพื่อยืนยันการลบรายการ <span class=\"label\" style=\"border: 1px solid #ccc;background-color:#fff;color:#333;\">"+ var_id + " : " + var_name +"</span> หรือเลือก <span class=\"label label-default\">ปิด</span> เพื่อยกเลิกการลบข้อมูล",
         title: "<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\" style=\"color:#d9534f;\"></i> ยืนยันการลบข้อมูล",
         buttons: {
            success: {
                label: "ลบข้อมูล",
                className: "btn-danger",
                callback: function() {
                    $.post("' . Url::toRoute([$model::CONTROLLER_ACTION_DELETEONE]) . '", {id: var_id});
                    },
                },
            close: {
                label: "ปิด",
                className: "btn-default",
                callback: function() {},
                },
            }
        });
        
});

', \yii\web\View::POS_READY); //POS_HEAD คือเอาไปไว้ที่ <header> ของเว็บไซต์
?>
<div class="product-index">

    <h2 style="display:inline;"><i class="fa fa-cube" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>

    <?php Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000, 'clientOptions' => ['method' => 'POST']]) ?>

    <div class="product-search">

        <div class="row">
            <div class="col-sm-6">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            </div>
            <div class="col-sm-6">

                <div class="pull-right" style="margin-top: 20px;">
                    <?= Html::a('<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>' . Yii::t('app', '<strong>เพิ่มสินค้า</strong>'), ['create'], ['class' => 'btn btn-info btn-sm', "style" => "margin: 0px 1px;"]) ?>

                    <?= Html::button('<i class="fa fa-trash-o fa-lg" aria-hidden="true" style="margin-right:7px;"></i>' . Yii::t('app', '<strong>ลบรายการที่เลือก</strong>'), ['class' => 'btn btn-warning btn-sm', 'id' => 'btnDeleteAll', "style" => "margin: 0px 1px;"]) ?>

                </div>
            </div>
        </div>
    </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'layout' => '<div>{summary}</div><div class="table-responsive">{items}</div><div>{pager}</div>',
        'showOnEmpty' => false, //ถ้าไม่มีข้อมูลในตาราง จะไม่แสดงฟอร์มตารางเปล่าๆ ขึ้นมา
        'options' => ['style' => 'margin-top:20px;', 'class' => 'grid-view', 'id' => 'productGridView'],
        'tableOptions' => ['class' => 'table table-bordered  table-striped table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => [ //สำหรับจัดการ style ของข้อมูลภายใน Cell
                    'style' => 'text-align:center;',
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;width:90px;min-width:90px;'
                ],
                'options' => [ //สำหรับจัดการ style ของกรอบตาราง
                    'style' => 'width:90px;min-width:90px;',
                ],
            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => [],
                'multiple' => true,
                'name' => 'productSelection', //เพิ่มเติมตรงนี้
                'headerOptions' => [
                    'style' => 'text-align:center;width:50px;min-width:50px;'
                ],
                'contentOptions' => [ //สำหรับจัดการ style ของข้อมูลภายใน Cell
                    'noWrap' => true,
                    'style' => 'text-align:center;',
                ],
                'options' => [ //สำหรับจัดการ style ของกรอบตาราง
                    'style' => 'width:50px;min-width:50px;',
                ],
            ],
            //'product_id',
            [
                'attribute' => 'product_name',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                ],
                'format' => 'raw', //แสดงผลเป็น HTML
                'value' => function($model) {
        
        $model_status = ($model->product_status == 1) ? '<span class="label label-success"><i class="fa fa-eye" aria-hidden="true"></i></span>' : '<span class="label label-danger"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>';
        
            return '<div class="label-group" style="display:inline;"><span class="label label-primary" style="background-color:#ff6600;">' . $model->product_code . '</span>' . $model_status .'</div> '. Html::a('<strong>' . $model->product_name . '</strong>', [$model::CONTROLLER_ACTION_VIEW, "id" => $model->product_id], ["data-pjax" => "0"]);
        }
            ],
            [
                'attribute' => 'category_id',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                ],
                'format' => 'raw', //แสดงผลเป็น HTML
                'value' => function($model) {

            $modelCategoryQuery = \app\models\Category::findOne(['category_id' => $model->category_id]);

            return '<span class="label label-pill label-primary" style="background-color:#ff6600;">ID : ' . $model->category_id . '</span> ' . Html::a($modelCategoryQuery->category_name, [\app\models\Category::CONTROLLER_ACTION_VIEW, "id" => $modelCategoryQuery->category_id], ["data-pjax" => "0"]);
        }
            ],
            //'product_detail:ntext',
            [
                'attribute' => 'product_price',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'value' => function($model){
                
                return ($model->product_price == 0) ? '<label class="label label-pill label-danger">ไม่ได้ตั้ง</label>' : Yii::$app->formatter->asCurrency($model->product_price);
                
                },
            ],
            [
                'attribute' => 'product_cost_per_unit',
                'format' => 'raw',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'value' => function($model){
                
                return ($model->product_cost_per_unit == 0) ? '<label class="label label-pill label-danger">ไม่ได้ตั้ง</label>' : Yii::$app->formatter->asCurrency($model->product_cost_per_unit);
                
                },
            ],
            [
                'attribute' => 'product_discount',
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'value' => function($model){
                
                return ($model->product_discount == 0) ? '<label class="label label-pill label-danger">ไม่ได้ตั้ง</label>' : Yii::$app->formatter->asCurrency($model->product_discount);
                
                },
            ],
            [
                'attribute' => 'product_amount',
                'label' => 'จำนวนคงคลัง',
                'format' => 'raw',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'value' => function($model){
                
                return ($model->product_amount == 0) ? '<label class="label label-pill label-danger">หมด</label>' : Yii::$app->formatter->asInteger($model->product_amount);
                
                },
            ],
            [
                'attribute' => 'product_stock_alert',
                'format' => 'raw',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'value' => function($model){
                
                return ($model->product_stock_alert == 0) ? '<label class="label label-pill label-danger">ไม่ได้ตั้ง</label>' : Yii::$app->formatter->asInteger($model->product_stock_alert);
                
                },
            ],
            [
                'attribute' => 'product_weight',
                'format' => 'raw',
                'label' => 'นน. (กรัม)',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'value' => function($model){
                
                return ($model->product_weight == 0) ? '<label class="label label-pill label-danger">ไม่ได้ตั้ง</label>' : Yii::$app->formatter->asInteger($model->product_weight);
                
                },
            ],
            // 'product_cost_per_unit_updated',
            // 'product_discount',
            [
                'attribute' => 'created_at',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'value' => function($model) {
            return Yii::$app->formatter->asDate($model->created_at, 'php: d/m/Y H:i:s');
        }
            ],
            [
                'attribute' => 'updated_at',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'value' => function($model) {
            return Yii::$app->formatter->asDate($model->updated_at, 'php: d/m/Y H:i:s');
        }
            ], 
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function($url, $model, $key) {

                        return Html::a("<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\"></i>", ["#"], ["style" => "color:#f0ad4e;", "data-id" => $model->product_id, "data-name" => $model->product_name, "id" => "btnDeleteOne"]);
                    }
                        ],
                        'buttonOptions' => ['class' => ''],
                        'template' => '{delete}',
                        'options' => [ //สำหรับจัดการ style ของกรอบตาราง
                            'style' => 'min-width:50px;width:50px;',
                        ],
                        'contentOptions' => [ //สำหรับจัดการ style ของข้อมูลภายใน Cell
                            'noWrap' => true,
                            'style' => 'text-align:center;min-width:50px;',
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>

</div>
