<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerJsFile('@web/js/jquery.maskMoney.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs("
    
$('#product-product_price').maskMoney({thousands:'', decimal:'.', allowZero:true});
$('#product-product_discount').maskMoney({thousands:'', decimal:'.', allowZero:true});
$('#product-product_cost_per_unit').maskMoney({thousands:'', decimal:'.', allowZero:true});
$('#product-product_wholesale_price').maskMoney({thousands:'', decimal:'.', allowZero:true});

", \yii\web\View::POS_READY);
?>

<div class="product-form" style="margin-top:20px;">

    <div class="row">
        <div class="col-sm-6">

            <?php
            $modelCategory = $model::categoryDropdownList();

            if ($modelCategory['count'] == 0) {
                echo '<div class="alert alert-danger fade in"><a href="' . Url::toRoute(['product/index']) . '" class="close" data-dismiss="alert" aria-label="close" data-method="POST">&times;</a>โปรดสร้าง <strong>&quot;กลุ่มสินค้า&quot;</strong> อย่างน้อย 1 กลุ่มสินค้า</div>';
            } else {

                $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                            'fieldConfig' => [
                                'template' => '{label}<div class=\"col-sm-8\">{input}<strong>{error}</strong></div>',
                                'labelOptions' => ['class' => 'control-label'],
                            ],
                ]);
                ?>

                <?= $form->field($model, 'category_id')->dropDownList($modelCategory['categoryList'], ['prompt' => 'เลือกกลุ่มสินค้า']) ?>
                <div class="row">
                    <div class="col-sm-8">
                        <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <?= $form->field($model, 'product_detail')->textarea(['rows' => 4, 'style' => 'resize: none;']) ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_price', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">บาท</span></div>'])->textInput(['maxlength' => true,])->label('ราคาขายปลีก');
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_discount', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">บาท</span></div>'])->textInput(['maxlength' => true,])->label('ราคาพิเศษ / ราคาลด');
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_wholesale_price', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">บาท</span></div>'])->textInput(['maxlength' => true,])->label('ราคาขายส่ง');
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_cost_per_unit', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">บาท</span></div>'])->textInput(['maxlength' => true,])->label('ราคาต้นทุน');
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_amount', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">ชิ้น</span></div>'])->input('number', ['maxlength' => true,]);
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_weight', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">กรัม</span></div>'])->input('number', ['maxlength' => true, 'step' => 'any'])->label('น้ำหนักสินค้า (ต่อชิ้น)');
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->field($model, 'product_stock_alert', ['template' => '{label}<div class="col-sm-12 input-group">{input}<span class="input-group-addon">ชิ้น</span></div>'])->input('number', ['maxlength' => true, 'step' => '10']);
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'product_status')->dropDownList(['1' => 'ใช้งาน (Active)', '0' => 'ระงับ (Inactive)',], ['options' => ['1' => ['Selected' => 'selected']], 'prompt' => 'เลือกสถานะ'])->label('สถานะสินค้า') ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>สร้างใหม่' : '<i class="fa fa-pencil-square" aria-hidden="true" style="margin-right:7px;"></i>ปรับปรุง', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
                    </div>
                </div>

                <?php
                ActiveForm::end();
            }
            ?>

        </div>
    </div>
</div>
