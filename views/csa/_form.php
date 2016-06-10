<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->registerJs('
    
$("#csaProvince").on("change", function(){

    $("#csaZipcode").val("");

    if($(this).val() == 78){

    $("#csaDistrict").val(0); $("#divCsaDistrict").hide();
    $("#csaSubDistrict").val(0); $("#divCsaSubDistrict").hide();
    $("#csaZipcode").val("");

    }
    else
    {

    $("#csaDistrict").val(0); $("#divCsaDistrict").show();
    $("#csaSubDistrict").val(0); $("#divCsaSubDistrict").show();
    $("#csaSubDistrict").html("<option value=\"\">เลือกตำบล / แขวง</option>");

    $.ajax({
                    url: "' . Url::to(["csa/district"]) . '",
                    dataType: "html",
                    data: {province_id: $(this).val()},
                    type: "post",
                    success: callback,
                });
            
    function callback(result){$("#csaDistrict").html(result);}

    }

});

$("#csaDistrict").on("change", function(){

$("#csaZipcode").val("");

$.ajax({
                url: "' . Url::to(["csa/subdistrict"]) . '",
                dataType: "html",
                data: {district_id: $(this).val()},
                type: "post",
                success: callback,
            });
            
function callback(result){$("#csaSubDistrict").html(result);}

});

$("#csaSubDistrict").on("change", function(){

$.ajax({
                url: "' . Url::to(["csa/zipcode"]) . '",
                dataType: "html",
                data: {subdistrict_id: $(this).val()},
                type: "post",
                success: callback,
            });
            
function callback(result){$("#csaZipcode").val(result);}

});

', \yii\web\View::POS_READY);
?>

<div class="csa-form" style="margin-top:20px;">

    <div class="row">
        <div class="col-sm-6">

            <?php
            $form = ActiveForm::begin([
                        'enableAjaxValidation' => true,
                        'fieldConfig' => [
                            'template' => '{label}<div class=\"col-sm-8\">{input}<strong>{error}</strong><h6>{hint}</h6></div>',
                            'labelOptions' => ['class' => 'control-label'],
                        ],
            ]);
            ?>

<?= $form->field($model, 'csa_name_surname')->widget(AutoComplete::className(), [
    'clientOptions' => [
        'autoFill'=>true,
        'source' => new JsExpression('function(request, response){$.ajax({url:"'.Url::to(["csa/namesuggestion"]).'", dataType: "json", data:{q: request.term}, success: function(result){response(result);}});}'),
    ],
])->textInput(['maxlength' => true])
?>

<?= $form->field($model, 'csa_type')->dropDownList([ 'Customer' => 'ลูกค้า (Customer)', 'Supplier' => 'คู่ค้า (Supplier)', 'Both' => 'เป็นทั้งลูกค้า และ คู่ค้า (Both)', 'Alliance' => 'พันธมิตรธุรกิจ (Alliance)',], ['options' => ['Customer' => ['Selected' => 'selected']], 'prompt' => 'เลือกสถานะลูกค้า คู่ค้า และ พันธมิตร'])->label('ประเภทลูกค้า คู่ค้า และ พันธมิตร'); ?>


            <?= $form->field($model, 'csa_company')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'csa_email')->widget(AutoComplete::className(), [
    'clientOptions' => [
        'autoFill'=>true,
        'source' => new JsExpression('function(request, response){$.ajax({url:"'.Url::to(["csa/emailsuggestion"]).'", dataType: "json", data:{q: request.term}, success: function(result){response(result);}});}'),
    ],
])->textInput(['maxlength' => true])
?>

            <?= $form->field($model, 'csa_phone')->textInput(['maxlength' => true])->hint("ตัวอย่าง 0XX-XXX-XXXX (มือถือ), 02-XXX-XXXX (กทม. และ ปริมณฑล) หรือ 0XX-XXX-XXX (ตจว.)") ?>

            <?= $form->field($model, 'csa_socialmedia')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'csa_address')->textarea(['rows' => 3, 'style' => 'resize: none;', "id" => "csaAddress"]) ?>
            <div class="row">
                <div class="col-sm-6">
<?= $form->field($model, 'csa_province_id')->dropDownList($model::provinceDropdownList(), ['prompt' => 'เลือกจังหวัด', 'id' => 'csaProvince']) ?>
                </div>
                <div class="col-sm-6" id="divCsaDistrict">
<?= $form->field($model, 'csa_district_id')->dropDownList($model::districtDropdownList($model->csa_province_id), ['prompt' => 'เลือกอำเภอ / เขต', 'id' => 'csaDistrict']) ?>
                </div>
                <div class="col-sm-6" id="divCsaSubDistrict">
<?= $form->field($model, 'csa_subdistrict_id')->dropDownList($model::subdistrictDropdownList($model->csa_district_id), ['prompt' => 'เลือกตำบล / แขวง', 'id' => 'csaSubDistrict']) ?>
                </div>
                <div class="col-sm-6" id="divCsaZipcode">
<?= $form->field($model, 'csa_zipcode')->textInput(['maxlength' => true, "id" => "csaZipcode"]) ?>
                </div>
            </div>
            
            <?= $form->field($model, 'csa_note')->textarea(['rows' => 4, 'style' => 'resize: none;']) ?>

            <div class="form-group">
                <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>สร้างใหม่' : '<i class="fa fa-pencil-square" aria-hidden="true" style="margin-right:7px;"></i>ปรับปรุง', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
                </div>
            </div>

<?php
ActiveForm::end();
?>

        </div>
    </div>
</div>