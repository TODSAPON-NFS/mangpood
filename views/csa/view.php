<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;
use yii\helpers\Url;
use \yii\validators\UrlValidator;

/* @var $this yii\web\View */
/* @var $model app\models\Csa */

$this->title = 'แสดงรายการลูกค้า คู่ค้า และพันธมิตรธุรกิจ';
$this->params['breadcrumbs'][] = ['label' => 'CSA', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'แสดง CSA > ' . $model->csa_name_surname;

$this->registerJs('
    
/* ลบทีละ 1 รายการ */

$("#lower_product_amount_point").tooltip();

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

', \yii\web\View::POS_READY);
?>
<div class="csa-view">

    <div class="row">
        <h2 style="display:inline;"><i class="fa fa-users" aria-hidden="true"></i> แสดงรายการลูกค้า คู่ค้า และพันธมิตรธุรกิจ</h2>
        <div class="pull-right" style="margin-bottom: 20px;">

            <?= Html::a("<i class=\"fa fa-plus-square fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i>" . Yii::t("app", "<strong>เพิ่ม CSA</strong>"), ["create"], ["class" => "btn btn-info btn-sm", "style" => "margin: 4px 1px 0px 1px;"]) ?>

            <?= Html::a("<i class=\"fa fa-pencil-square fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i><strong>ปรับปรุง</strong>", ["update", "id" => $model->csa_id], ["class" => "btn btn-primary btn-sm", "style" => "margin: 4px 1px 0px 1px;"]) ?>

            <?= Html::button("<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i>" . Yii::t("app", "<strong>ลบรายการนี้</strong>"), ["class" => "btn btn-warning btn-sm", "data-id" => $model->csa_id, "data-name" => $model->csa_name_surname, "id" => "btnDeleteOne", "style" => "margin: 4px 1px 0px 1px;"]) ?>

        </div>
    </div>
    <?php
    
    $validator = new UrlValidator();
    
    if($validator->validate($model->csa_socialmedia, $error)){
        $url = '<a href="'.$model->csa_socialmedia.'" target="_blank">'.$model->csa_socialmedia.'</a>';
    }
    else{
        $url = $model->csa_socialmedia;
    }
    
    ?>

    <div class="row">

        <div class="table-responsive">

            <?=
            DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'template' => '<tr><th style="min-width:200px;width:200px;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    [
                        'attribute' => 'csa_name_surname',
                        'label' => '[รหัส] ชื่อ - นามสกุล CSA',
                        'format' => 'html',
                        'value' => '<span class="label label-pill label-primary" style="background-color:#ff6600;vertical-align:middle;">ID : ' . $model->csa_id . '</span> &nbsp;<strong style="font-size:1.5em;vertical-align:middle;line-height:20px;">' . $model->csa_name_surname . '</strong>',
                    ],
                    [
                        'attribute' => 'csa_type',
                        'label' => 'ประเภท CSA',
                        'format' => 'text',
                    ],
                    [
                        'attribute' => 'csa_company',
                        'format' => 'raw',
                        'value' => ($model->csa_company != "") ? $model->csa_company : '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>',
                    ],
                    [
                        'attribute' => 'csa_email',
                        'format' => 'raw',
                        'value' => ($model->csa_email != "") ? Yii::$app->formatter->asEmail($model->csa_email) : '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>',
                    ],
                    [
                        'attribute' => 'csa_phone',
                        'format' => 'raw',
                        'value' => ($model->csa_phone != "") ? '<a href="tel:'.$model->csa_phone.'">'.$model->csa_phone.'</a>' : '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>',
                    ],
                    [
                        'attribute' => 'csa_socialmedia',
                        'format' => 'raw',
                        'value' => ($model->csa_socialmedia != "") ? $url : '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>',
                    ],
                    [
                        'attribute' => 'csa_address',
                        'format' => 'raw',
                        'value' => ($model->csa_address == "" && empty($model->csa_province_id) && empty($model->csa_district_id) && empty($model->csa_subdistrict_id) && (empty($model->csa_zipcode) || $model->csa_zipcode == "00000")) ? '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>' : nl2br($model->csa_address).'<p style="margin:0px;">'.$model::subdistrictNameRequest($model->csa_subdistrict_id).$model::districtNameRequest($model->csa_district_id).'</p><p style="margin:0px;">'.$model::provinceNameRequest($model->csa_province_id) .'</p><h4 style="margin:3px 0px 0px 0px;">'. $model::zipcodeRequest($model->csa_zipcode).'</h4>',
                    ],
                    [
                        'attribute' => 'csa_note',
                        'format' => 'raw',
                        'value' => ($model->csa_note != "") ? nl2br($model->csa_note) : '<label class="label label-pill label-danger">ไม่มีข้อมูล</label>',
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => Yii::$app->formatter->asDate($model->created_at, "php: d/m/Y H:i:s")
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => Yii::$app->formatter->asDate($model->updated_at, "php: d/m/Y H:i:s").' ('.Yii::$app->formatter->asRelativeTime($model->updated_at).')',
                    ],
                ],
            ])
            ?>

        </div>
    </div>
</div>
