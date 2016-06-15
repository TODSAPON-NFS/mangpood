<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\jui\DatePicker;

$this->registerCss(".expand_input_class { padding:0px 2px; }");
$this->registerJs('

$(".pipelineNewProductList").on("click", function(){

    $(this).css("display", "none");

    var pipelineNewProductListValue = parseInt($(this).val());
    var pipelineNewProductListValuePlus = pipelineNewProductListValue + 5;
    for (i=pipelineNewProductListValue; i < pipelineNewProductListValuePlus; i++){
    
        $(".pipelineProductList").eq(i).css("display", "");

}

if(pipelineNewProductListValuePlus%5 == 0){
    var j = parseInt(pipelineNewProductListValuePlus/5);
    $(".pipelineNewProductList").eq(j).css("display", "");
    $(".pipelineNewProductListTr").eq(j).css("display", "");
}

$("#pipelineProductListTableHeader").css("display", "");
$("#pipelineProductListTableFooter").css("display", "");
});

$(".pipelineProductId").each(function (i) {
    var productPipelineId = (function (i) {
        return {
            source: function(request, response){
            $.ajax({
                    url:"' . Url::to(["product/productidsuggestion"]) . '", 
                    dataType: "json", 
                    data:{q: request.term}, 
                    success: function(result){
                        response(result);
                        }});
            },
            minLength: 1,
            select: function(event, ui) {
                if(document.pipeline_form.elements["PipelineForm[csa_type]"].value == "Supplier"){
                    var wholesaleprice = parseInt(ui.item.wholesaleprice);
                    document.pipeline_form.elements["PipelineForm[product_price][]"][i].value = wholesaleprice.toFixed(2);
                }
                else{
                    var price = parseInt(ui.item.price);
                    document.pipeline_form.elements["PipelineForm[product_price][]"][i].value = price.toFixed(2);
                }
                document.pipeline_form.elements["PipelineForm[product_name][]"][i].value = ui.item.name;
                document.pipeline_form.elements["PipelineForm[product_amount][]"][i].value = 1;
                document.pipeline_form.elements["PipelineForm[product_weight][]"][i].value = ui.item.weight;
                
                checkProductDuplication();
            }
        };
    })(i);
    $(this).autocomplete(productPipelineId);
});

$(".pipelineProductName").each(function (i) {
    var productPipelineName = (function (i) {
        return {
            source: function(request, response){
            $.ajax({
                    url:"' . Url::to(["product/productnamesuggestion"]) . '", 
                    dataType: "json", 
                    data:{q: request.term}, 
                    success: function(result){
                        response(result);
                        }});
            },
            minLength: 3,
            select: function(event, ui) {
                if(document.pipeline_form.elements["PipelineForm[csa_type]"].value == "Supplier"){
                    var wholesaleprice = parseInt(ui.item.wholesaleprice);
                    document.pipeline_form.elements["PipelineForm[product_price][]"][i].value = wholesaleprice.toFixed(2);
                }
                else{
                    var price = parseInt(ui.item.price);
                    document.pipeline_form.elements["PipelineForm[product_price][]"][i].value = price.toFixed(2);
                }
                document.pipeline_form.elements["PipelineForm[product_code][]"][i].value = ui.item.code;
                document.pipeline_form.elements["PipelineForm[product_amount][]"][i].value = 1;
                document.pipeline_form.elements["PipelineForm[product_weight][]"][i].value = ui.item.weight;
                
                checkProductDuplication();
            }
        };
    })(i);
    $(this).autocomplete(productPipelineName);
});

function checkContactEmpty(){

    if(($("#csaPhone").val() == "") && ($("#csaEmail").val() == "") && ($("#csaSocialMedia").val() == ""))
        {
        $(".field-csaPhone").addClass("has-error");
        $(".field-csaEmail").addClass("has-error");
        $(".field-csaSocialMedia").addClass("has-error");
        return false;
        }
    else{
        $(".field-csaPhone").removeClass("has-error");
        $(".field-csaEmail").removeClass("has-error");
        $(".field-csaSocialMedia").removeClass("has-error");
        $(".field-csaPhone").addClass("has-success");
        $(".field-csaEmail").addClass("has-success");
        $(".field-csaSocialMedia").addClass("has-success");
        return true;    
    }

}

/* 1. ตรวจหาความซ้ำซ้อน */
function checkProductDuplication(){



checkProductAmountSum();
}

/* 2. หาจำนวนรวมสุดท้าย */
function checkProductAmountSum(){

    var amountSum = 0;
    var i = 0;
    var multiply = 0;
    
    $(".pipelineProductAmount").each(function(i){
        
        if( $.isNumeric($(this).val()) ) {
            
            amountSum = amountSum + parseInt($(this).val());
        }

    });

$("#pipelineProductAmountSum").val(amountSum);
checkProductPriceSum();
}

/* 3. หาราคารวมสุดท้าย */
function checkProductPriceSum(){

    var priceMultiply = 0;
    var pricePerPiece = 0;
    var priceSum = 0;

    $(".pipelineProductPrice").each(function(i){
        
        if(($.isNumeric(document.pipeline_form.elements["PipelineForm[product_price][]"][i].value)) && ($.isNumeric(document.pipeline_form.elements["PipelineForm[product_amount][]"][i].value))) {
            
            priceMultiply = document.pipeline_form.elements["PipelineForm[product_price][]"][i].value * document.pipeline_form.elements["PipelineForm[product_amount][]"][i].value;
            document.pipeline_form.elements["PipelineForm[product_price_per_piece_sum][]"][i].value = priceMultiply.toFixed(2);
            
            priceSum = parseFloat(priceSum) + parseFloat(document.pipeline_form.elements["PipelineForm[product_price_per_piece_sum][]"][i].value);
        }

    });

$("#pipelineProductPriceSum").val(priceSum.toFixed(2));
checkProductWeightSum();
}

/* 4. หาน้ำหนักรวมสุดท้าย */
function checkProductWeightSum(){

    var weightSum = 0;
    $(".pipelineProductWeight").each(function(){
        
        if( $.isNumeric($(this).val())) {
            weightSum = weightSum + parseInt($(this).val());
        }

    });

$("#pipelineProductWeightSum").val(weightSum);
}

$("#w0").on("keypress", function(event){

    if (event.which == 13 || event.keyCode == 13) {
            return false;
        }
    else{
        return true;
    }
});

$(".pipelineProductWeight").on("change", function(){checkProductDuplication();});
$(".pipelineProductAmount").on("change", function(){checkProductDuplication();});
$(".pipelineProductPrice").on("change", function(){checkProductDuplication();});

$("#pipelineSubmit").on("click", function(){return checkContactEmpty();});
$("#csaPhone, #csaEmail, #csaSocialMedia").on("change focus", function(){return checkContactEmpty();});

', \yii\web\View::POS_READY);
?>

<div class="pipeline-form" style="margin-top:20px;">

    <div class="row">
        <div class="col-sm-12">

            <?php
            $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['pipeline/pipeline'],
                        'enableAjaxValidation' => true,
                        'options' => ['name' => 'pipeline_form'],
                        'fieldConfig' => [
                            'template' => '{label}<div class=\"col-sm-8\">{input}<strong>{error}</strong><h6>{hint}</h6></div>',
                            'labelOptions' => ['class' => 'control-label'],
                        ],
            ]);
            ?>

            <div class="row">
                <div class="col-sm-5">

                    <?php if (Yii::$app->session->getFlash('noContact')) : ?>
                        <div class="alert alert-danger fade in" style="margin: 20px 0px 0px 0px;padding:10px 20px;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> <?php echo Yii::$app->session->getFlash('noContact'); ?>
                        </div>
                    <?php endif; ?>

                    <h3><i class="fa fa-users" aria-hidden="true" style="vertical-align: baseline;"></i> <?= Html::encode("รายละเอียด CSA") ?></h3>

                    <div class="row" style="margin-top:20px;">
                        <div class="col-sm-4">

                            <?=
                            $form->field($model, 'pipeline_date')->widget(DatePicker::classname(), [
                                'language' => 'th',
                                'dateFormat' => 'dd-MM-yyyy',
                            ])->textInput(['value' => date('d-m-Y'), 'style' => 'text-align:center;', 'maxlength' => 10]);
                            ?>

                        </div>

                        <div class="col-sm-5">

                            <?=
                            $form->field($model, 'csa_name_surname')->widget(AutoComplete::className(), [
                                'clientOptions' => [
                                    'autoFill' => true,
                                    'minLength' => 2,
                                    'source' => new JsExpression('function(request, response){$.ajax({url:"' . Url::to(["csa/namesuggestion"]) . '", dataType: "json", data:{q: request.term}, success: function(result){response(result);}});}'),
                                    'select' => new JsExpression('function(event, ui){$("#csaId").val(ui.item.id);$("#csaAddress").val(ui.item.address);$("#csaPhone").val(ui.item.phone);$("#csaEmail").val(ui.item.email);$("#pipelineform-csa_subdistrict_id").val(ui.item.subdistrict);$("#pipelineform-csa_district_id").val(ui.item.district);$("#pipelineform-csa_province_id").val(ui.item.province);$("#csaZipcode").val(ui.item.zipcode);$("#csaSocialMedia").val(ui.item.socialmedia);$("#csaNote").val(ui.item.note);$("#csaType").val(ui.item.type);$("#csaCompany").val(ui.item.company);}'),
                                ],
                            ])->textInput(['maxlength' => true])
                            ?>

                        </div>

                        <div class="col-sm-3">

                            <?= $form->field($model, 'csa_id')->textInput(['readonly' => true, 'id' => 'csaId', 'style' => 'text-align:center;background-color:#fff;'])->label('CSA ID');
                            ?>

                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'csa_type')->dropDownList([ 'Customer' => 'ลูกค้า (Customer)', 'Supplier' => 'คู่ค้า (Supplier)', 'Both' => 'เป็นทั้งลูกค้า และ คู่ค้า (Both)', 'Alliance' => 'พันธมิตรธุรกิจ (Alliance)',], ['options' => ['Customer' => ['Selected' => 'selected']], 'prompt' => 'เลือกสถานะลูกค้า คู่ค้า และ พันธมิตร', 'id' => 'csaType'])->label('ประเภทลูกค้า คู่ค้า และ พันธมิตร'); ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'csa_phone')->textInput(['maxlength' => true, 'id' => 'csaPhone']) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'csa_company')->textInput(['maxlength' => true, 'id' => 'csaCompany']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'csa_email')->textInput(['maxlength' => true, 'id' => 'csaEmail']); ?>
                        </div>

                        <div class="col-sm-6">
                            <?= $form->field($model, 'csa_socialmedia')->textInput(['maxlength' => true, 'id' => 'csaSocialMedia']); ?>
                        </div>

                        <div class="col-sm-12">

                            <?= $form->field($model, 'csa_address')->textarea(['rows' => 2, 'style' => 'resize: none;', "id" => "csaAddress"]) ?>

                        </div>
                        <div class="col-sm-6">

                            <?=
                            $form->field($model, 'csa_subdistrict_id')->widget(AutoComplete::className(), [
                                'clientOptions' => [
                                    'autoFill' => true,
                                    'minLength' => 4,
                                    'source' => new JsExpression('function(request, response){$.ajax({url:"' . Url::to(["csa/subdistrictsuggestion"]) . '", dataType: "json", data:{q: request.term}, success: function(result){response(result);}});}'),
                                ],
                            ])->textInput(['maxlength' => true])
                            ?>

                        </div>
                        <div class="col-sm-6">

                            <?=
                            $form->field($model, 'csa_district_id')->widget(AutoComplete::className(), [
                                'clientOptions' => [
                                    'autoFill' => true,
                                    'minLength' => 3,
                                    'source' => new JsExpression('function(request, response){$.ajax({url:"' . Url::to(["csa/districtsuggestion"]) . '", dataType: "json", data:{q: request.term}, success: function(result){response(result);}});}'),
                                ],
                            ])->textInput(['maxlength' => true])
                            ?>

                        </div>
                        <div class="col-sm-6">

                            <?=
                            $form->field($model, 'csa_province_id')->widget(AutoComplete::className(), [
                                'clientOptions' => [
                                    'autoFill' => true,
                                    'minLength' => 2,
                                    'source' => new JsExpression('function(request, response){$.ajax({url:"' . Url::to(["csa/provincesuggestion"]) . '", dataType: "json", data:{q: request.term}, success: function(result){response(result);}});}'),
                                ],
                            ])->textInput(['maxlength' => true])
                            ?>

                        </div>
                        <div class="col-sm-6">

                            <?= $form->field($model, 'csa_zipcode')->textInput(["id" => "csaZipcode"]) ?>

                        </div>
                        <div class="col-sm-12">

                            <?= $form->field($model, 'csa_note')->textarea(['rows' => 3, 'style' => 'resize: none;', "id" => "csaNote"])->hint('หมายเหตุในส่วนของลูกค้า คู่ค้า และพันธมิตรธุรกิจ') ?>

                        </div>
                    </div>
                </div>

                <div class="col-sm-7">

                    <h3><i class="fa fa-cube" aria-hidden="true" style="vertical-align: baseline;"></i> <?= Html::encode("รายการสั่งซื้อ") ?></h3>

                    <!-- รายการสินค้าที่ 1-5 -->
                    <div class="table-responsive" style="margin-top:20px;">
                        <table>
                            <tr id="pipelineProductListTableHeader" style="display:none;">
                                <th style="text-align:center;min-width:80px;">รหัส</th>
                                <th style="text-align:center;min-width:150px;">รายการสินค้า</th>
                                <th style="text-align:center;min-width:80px;">จำนวน</th>
                                <th style="text-align:center;min-width:90px;">ราคา</th>
                                <th style="text-align:center;min-width:90px;">ราคารวม</th>
                                <th style="text-align:center;min-width:80px;">น้ำหนัก</th>
                            </tr>

                            <tr class="pipelineNewProductListTr">
                                <td colspan="4" style="padding:5px;"><?= Html::button("เพิ่มรายการสินค้า", ['class' => 'btn btn-default pipelineNewProductList', 'style' => 'margin-bottom:5px;', 'value' => 0]) ?></td>
                            </tr>

                            <?php for ($i = 0; $i < 50; $i++) : ?>

                                <?php if ($i % 5 == 0 && $i != 0): ?>
                                    <tr class="pipelineNewProductListTr" style="display:none;">
                                        <td colspan="4" style="padding:5px;"><?= Html::button("เพิ่มรายการสินค้า", ['class' => 'btn btn-default pipelineNewProductList', 'style' => 'margin-bottom:5px;display:none', 'value' => $i]) ?></td>
                                    </tr>
                                <?php endif; ?>

                                <tr class="pipelineProductList" style="display: none;">
                                    <td style="padding: 5px;"><?= Html::activeTextInput($model, 'product_code[]', ['class' => 'form-control pipelineProductId', 'style' => 'text-align:center;']); ?></td>
                                    <td style="padding: 5px;"><?= Html::activeTextInput($model, 'product_name[]', ['class' => 'form-control pipelineProductName']); ?></td>
                                    <td style="padding: 5px;"><?= Html::activeInput('number', $model, 'product_amount[]', ['class' => 'form-control pipelineProductAmount', 'style' => 'text-align:center;', 'min' => 1,]); ?></td>
                                    <td style="padding: 5px;"><?= Html::activeTextInput($model, 'product_price[]', ['class' => 'form-control pipelineProductPrice', 'style' => 'text-align:right;']); ?></td>
                                    <td style="padding: 5px;"><?= Html::activeTextInput($model, 'product_price_per_piece_sum[]', ['class' => 'form-control pipelineProductPricePerPieceSum', 'style' => 'text-align:right;']); ?></td>
                                    <td style="padding: 5px;"><?= Html::activeTextInput($model, 'product_weight[]', ['class' => 'form-control pipelineProductWeight', 'style' => 'text-align:center;']); ?></td>
                                </tr>

                            <?php endfor; ?>

                            <tr id="pipelineProductListTableFooter" style="display: none;">
                                <td colspan="2"></td>
                                <td style="padding: 5px;"><?= $form->field($model, 'product_amount_sum')->textInput(['id' => 'pipelineProductAmountSum', 'class' => 'form-control', 'style' => 'text-align:center;background-color:#fff;', 'readonly' => true])->label('รวมจำนวน'); ?></td>
                                <td></td>
                                <td style="padding: 5px;"><?= $form->field($model, 'product_price_sum')->textInput(['id' => 'pipelineProductPriceSum', 'class' => 'form-control', 'style' => 'text-align:center;background-color:#fff;', 'readonly' => true])->label('ราคารวม'); ?></td>
                                <td style="padding: 5px;"><?= $form->field($model, 'product_amount_weight')->textInput(['id' => 'pipelineProductWeightSum', 'class' => 'form-control', 'style' => 'text-align:center;background-color:#fff;', 'readonly' => true])->label('รวม นน.'); ?></td>
                            </tr>

                        </table>
                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <?= $form->field($model, 'pipeline_note')->textarea(['rows' => 3, 'style' => 'resize: none;', "id" => "pipelineNote"])->hint('หมายเหตุเกี่ยวกับเหตุการณ์ (Pipeline) ครั้งนี้') ?>

                        </div>

                    </div>

                    <div class="row" style="margin-top:20px;">
                        <div class="form-group" style="text-align: right;">

                            <?= Html::submitButton('<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>บันทึก', ['class' => 'btn btn-info', 'id' => 'pipelineSubmit']) ?> <?= Html::resetButton("เริ่มใหม่", ['class' => 'btn btn-default']) ?>

                        </div>
                    </div>





                </div>

            </div>

            <?php
            ActiveForm::end();
            ?>    

        </div>
    </div>
</div>