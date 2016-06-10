<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CsaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ลูกค้า คู่ค้า และพันธมิตรธุรกิจ';
$this->params['breadcrumbs'][] = 'ลูกค้า คู่ค้า และพันธมิตรธุรกิจ (CSA)';
$this->registerCss(".summary { margin-bottom:10px; }");

/* ลบทีละหลายรายการ */
$this->registerJs('
    
    $("#btnDeleteAll").click(function(){
            var keys = $("#csaGridView").yiiGridView("getSelectedRows");
    
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

<div class="csa-index">

    <h2 style="display:inline;"><i class="fa fa-users" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>

    <?php Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000, 'clientOptions' => ['method' => 'POST']]) ?>

    <div class="csa-search">

        <div class="row">
            <div class="col-sm-6">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            </div>
            <div class="col-sm-6">

                <div class="pull-right" style="margin-top: 20px;">
                    <?= Html::a('<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>' . Yii::t('app', '<strong>เพิ่ม CSA</strong>'), ['create'], ['class' => 'btn btn-info btn-sm', "style" => "margin: 0px 1px;", "data-pjax" => "0"]) ?>

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
        'options' => ['style' => 'margin-top:20px;', 'class' => 'grid-view', 'id' => 'csaGridView'],
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
                'name' => 'csaSelection', //เพิ่มเติมตรงนี้
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
            //'csa_id',
            [
                'attribute' => 'csa_name_surname',
                'label' => 'ชื่อ - นามสกุล',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                ],
                'format' => 'html', //แสดงผลเป็น HTML
                'value' => function($model) {
            return '<span class="label label-pill label-primary" style="background-color:#ff6600;">ID : ' . $model->csa_id . '</span> ' . Html::a('<strong>' . $model->csa_name_surname . '</strong>', [$model::CONTROLLER_ACTION_VIEW, "id" => $model->csa_id], ["data-pjax" => "0"]);
        }
            ],
            [
                'attribute' => 'csa_type',
                'label' => 'ประเภท',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'format' => 'text',
            ],
            [
                'attribute' => 'csa_company',
                'label' => 'องค์กร',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'format' => 'raw',
                'value' => function($model) {

            return ($model->csa_company == '') ? '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>' : $model->csa_company;
        },
            ],
            [
                'attribute' => 'csa_email',
                'label' => 'อีเมล์',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'format' => 'raw',
                'value' => function($model) {

            return ($model->csa_email == '') ? '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>' : Yii::$app->formatter->asEmail($model->csa_email);
        },
            ],
            [
                'attribute' => 'csa_phone',
                'headerOptions' => ['style' => 'text-align:center;'],
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'format' => 'raw',
                'value' => function($model) {

            return ($model->csa_phone == '') ? '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>' : '<a href="tel:' . $model->csa_phone . '">' . $model->csa_phone . '</a>';
        },
            ],
            // 'csa_socialmedia',
            [
                'attribute' => 'csa_district_id',
                'label' => 'อำเภอ',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;',
                ],
                'format' => 'raw',
                'value' => function($model) {
            
            return (empty($model->csa_district_id)) ? '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>' : $model::districtNameRequest($model->csa_district_id);
            
        },
            ],
            [
                'attribute' => 'csa_province_id',
                'contentOptions' => [
                    'noWrap' => true,
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;',
                ],
                'format' => 'raw',
                'value' => function($model) {
            
            return (empty($model->csa_province_id)) ? '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>' : $model::provinceNameRequest($model->csa_province_id);
            
        },
            ],
            // 'csa_zipcode_id',
            // 'csa_address:ntext',
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

                        return Html::a("<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\"></i>", ["#"], ["style" => "color:#f0ad4e;", "data-id" => $model->csa_id, "data-name" => $model->csa_name_surname, "id" => "btnDeleteOne"]);
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
