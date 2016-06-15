<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'แสดงสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'สินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' > ' . $model->product_name;

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
<div class="product-view">
    <div class="row">
        <h2 style="display:inline;"><i class="fa fa-cube" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>
        <div class="pull-right" style="margin-bottom: 20px;">

            <?= Html::a("<i class=\"fa fa-plus-square fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i>" . Yii::t("app", "<strong>เพิ่มสินค้า</strong>"), ["create"], ["class" => "btn btn-info btn-sm", "style" => "margin: 4px 1px 0px 1px;"]) ?>

            <?= Html::a("<i class=\"fa fa-pencil-square fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i><strong>ปรับปรุง</strong>", ["update", "id" => $model->product_id], ["class" => "btn btn-primary btn-sm", "style" => "margin: 4px 1px 0px 1px;"]) ?>

            <?= Html::button("<i class=\"fa fa-trash-o fa-lg\" aria-hidden=\"true\" style=\"margin-right:7px;\"></i>" . Yii::t("app", "<strong>ลบรายการนี้</strong>"), ["class" => "btn btn-warning btn-sm", "data-id" => $model->product_id, "data-name" => $model->product_name, "id" => "btnDeleteOne", "style" => "margin: 4px 1px 0px 1px;"]) ?>

        </div>
        <?php
        $product_status = ($model->product_status == 1) ? '<label class="label label-pill label-success">เปิดใช้งาน (Active)</label>' : '<label class="label label-pill label-danger">ระงับการใช้งาน (Inactive)</label>';
        
        ?>
    </div>
    
    <div class="row">

        <div class="table-responsive">
            <?=
            DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'],
                'template' => '<tr><th style="min-width:200px;width:200px;">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                    [
                        'attribute' => 'product_name',
                        'label' => '[รหัส] ชื่อสินค้า',
                        'format' => 'html',
                        'value' => '<span class="label label-pill label-primary" style="background-color:#ff6600;vertical-align:middle;">ID : ' . $model->product_code . '</span> &nbsp;<strong style="font-size:1.5em;vertical-align:middle;line-height:20px;">' . $model->product_name . '</strong>',
                    ],
                    [
                        'attribute' => 'category_id',
                        'label' => '[รหัส] กลุ่มสินค้า',
                        'format' => 'html',
                        'value' => '<span class="label label-pill label-primary" style="background-color:#ff6600;">ID : ' . $model->category_id . '</span> &nbsp;<strong>' . $modelCategory->category_name . '</strong>',
                    ],
                    [
                        'attribute' => 'product_status',
                        'label' => 'สถานะสินค้า',
                        'format' => 'raw',
                        'value' => $product_status,
                    ],
                    [
                        'attribute' => 'product_detail',
                        'label' => 'รายละเอียดสินค้า',
                        'format' => 'html',
                        'value' => StringHelper::truncate(nl2br($model->product_detail), 200, $suffix = '...'),
                    ],
                    [
                        'attribute' => 'product_price',
                        'label' => 'ราคาขายปลีกปกติ',
                        'format' => 'raw',
                        'value' => ($model->product_price > 0) ? Yii::$app->formatter->asCurrency($model->product_price) : '<label class="label label-pill label-danger">ไม่ได้ตั้งราคาไว้</label>',
                    ],
                    [
                        'attribute' => 'product_discount',
                        'format' => 'raw',
                        'value' => ($model->product_discount > 0) ? Yii::$app->formatter->asCurrency($model->product_discount) : '<label class="label label-pill label-danger">ไม่ได้ตั้งราคาไว้</label>',
                    ],
                    [
                        'attribute' => 'product_wholesale_price',
                        'format' => 'raw',
                        'value' => ($model->product_wholesale_price > 0) ? Yii::$app->formatter->asCurrency($model->product_wholesale_price) : '<label class="label label-pill label-danger">ไม่ได้ตั้งราคาไว้</label>',
                    ],
                    [
                        'attribute' => 'product_cost_per_unit',
                        'format' => 'raw',
                        'value' => ($model->product_cost_per_unit > 0) ? Yii::$app->formatter->asCurrency($model->product_cost_per_unit) : '<label class="label label-pill label-danger">ไม่ได้ตั้งราคาไว้</label>',
                    ],
                    [
                        'attribute' => 'product_amount',
                        'format' => 'raw',
                        'value' => ($model->product_amount <= $model->product_stock_alert) ? '<label id="lower_product_amount_point" class="label label-pill label-danger" style="font-size:1em;" data-toggle="tooltip" data-placement="right" title="จำนวนสินค้าน้อยกว่าจุดสั่งซื้อแล้ว">'.Yii::$app->formatter->asDecimal($model->product_amount).'</label> ชิ้น' : '<label class="label label-pill label-success" style="font-size:1em;">'.Yii::$app->formatter->asDecimal($model->product_amount).'</label> ชิ้น',
                    ],
                    [
                        'attribute' => 'product_stock_alert',
                        'label' => 'จุดสั่งซื้อ',
                        'format' => 'raw',
                        'value' => ($model->product_stock_alert != 0) ? 'สั่งซื้อเมื่อสินค้าเหลือ <label class="label label-pill label-warning" style="font-size:1em;">'.Yii::$app->formatter->asDecimal($model->product_stock_alert).'</label> ชิ้น' : '<label class="label label-pill label-danger">ไม่ได้ตั้งจำนวนไว้</label>',
                    ],
                    //'product_cost_per_unit_updated',
                    [
                        'attribute' => 'product_weight',
                        'label' => 'น้ำหนักสินค้า',
                        'format' => 'raw',
                        'value' => ($model->product_weight > 0) ? Yii::$app->formatter->asInteger($model->product_weight).' กรัม' : '<label class="label label-pill label-danger">ไม่ได้ตั้งน้ำหนักไว้</label>',
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