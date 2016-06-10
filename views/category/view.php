<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'แสดงกลุ่มสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' > ' . $model->category_name;

$this->registerJs('
    
/* ลบทีละ 1 รายการ */

$(document).on("click", "#btnDeleteOne", function(event){
    
    event.preventDefault();
    var var_id = $(this).data("id");
    var var_name = $(this).data("name");
    
    bootbox.dialog({
         message: "โปรดเลือก <span class=\"label label-danger\">ลบข้อมูล</span> เพื่อยืนยันการลบรายการ หรือเลือก <span class=\"label label-default\">ปิด</span> เพื่อยกเลิกการลบข้อมูล<br /><br /><span class=\"badge\"><i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i> หมายเหตุ</span> การลบกลุ่มสินค้าจะสำเร็จได้ต่อเมื่อ<u>ไม่มี</u> &quot;สินค้า&quot; อยู่ภายใต้ &quot;กลุ่มสินค้า&quot; นี้",
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

', \yii\web\View::POS_READY); //POS_HEAD คือเอาไปไว้ที่ <header> ของเว็บไซต์ POS_READY คือรันแบบ onload
?>

<div class="category-view">

    <h2 style="display:inline;"><i class="fa fa-cubes" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>
    <div class="pull-right" style="margin-bottom: 20px;">

        <?= Html::a("<i class=\"fa fa-plus-square fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i>" . Yii::t("app", "<strong>เพิ่มกลุ่มสินค้า</strong>"), ["create"], ["class" => "btn btn-info btn-sm","style" => "margin: 4px 1px 0px 1px;"]) ?>

        <?= Html::a("<i class=\"fa fa-pencil-square fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i><strong>ปรับปรุง</strong>", ["update", "id" => $model->category_id], ["class" => "btn btn-primary btn-sm","style" => "margin: 4px 1px 0px 1px;"]) ?>

        <?= Html::button("<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i>" . Yii::t("app", "<strong>ลบรายการนี้</strong>"), ["class" => "btn btn-warning btn-sm", "data-id" => $model->category_id, "data-name" => $model->category_name, "id" => "btnDeleteOne","style" => "margin: 4px 1px 0px 1px;"]) ?>

    </div>

    <?=
    DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="width:200px;">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'category_name',
                'label' => '[รหัส] ชื่อกลุ่มสินค้า',
                'format' => 'html',
                'value' => '<span class="label label-pill label-primary" style="background-color:#ff6600;vertical-align:middle;">ID : ' . $model->category_id . '</span> &nbsp;<strong style="font-size:1.5em;vertical-align:middle;line-height:20px;">' . $model->category_name . '</strong>',
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
