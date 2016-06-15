<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'บันทึกเหตุการณ์ (Pipeline)';
$this->params['breadcrumbs'][] = $this->title;

/* ลบทีละหลายรายการ */
$this->registerJs('
    
    $("#btnDeleteAll").click(function(){
            var keys = $("#pipelineGridView").yiiGridView("getSelectedRows");
    
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
<div class="pipeline-index">

<h2 style="display:inline;"><i class="fa fa-table" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>

    <?php Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000, 'clientOptions' => ['method' => 'POST']]) ?>

    <div class="pipeline-search">

        <div class="row">
            <div class="col-sm-6">

                <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

            </div>
            <div class="col-sm-6">

                <div class="pull-right" style="margin-top: 20px;">
                    <?= Html::a('<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>' . Yii::t('app', '<strong>เพิ่มเหตุการณ์</strong>'), ['create'], ['class' => 'btn btn-info btn-sm', "style" => "margin: 0px 1px;", "data-pjax" => "0"]) ?>

                    <?= Html::button('<i class="fa fa-trash-o fa-lg" aria-hidden="true" style="margin-right:7px;"></i>' . Yii::t('app', '<strong>ลบรายการที่เลือก</strong>'), ['class' => 'btn btn-warning btn-sm', 'id' => 'btnDeleteAll', "style" => "margin: 0px 1px;"]) ?>

                </div>
            </div>
        </div>
    </div>

<?php Pjax::end(); ?>
    
</div>