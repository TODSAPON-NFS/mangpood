<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'post',
            'options' => ['data-pjax' => true], //<== เพิ่มเข้ามา
        ]);
?>

<!--เพิ่มเข้ามา-->

<div class="input-group input-group-sm" style="margin-top: 20px;">
    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
    <span class="input-group-btn">
        <button class="btn" style="background-color:#ff6600;color: #fff;" type="submit"><i class="glyphicon glyphicon-search"></i> <strong>ค้นหา</strong></button>
    </span>
</div>

<!--จบเพิ่มเข้ามา-->


    <?php //$form->field($model, 'product_id') ?>

    <?php //$form->field($model, 'category_id') ?>

    <?php //$form->field($model, 'product_name') ?>

    <?php //$form->field($model, 'product_detail') ?>

    <?php //$form->field($model, 'product_price') ?>

    <?php // echo $form->field($model, 'product_amount') ?>

    <?php // echo $form->field($model, 'product_cost_per_unit') ?>

    <?php // echo $form->field($model, 'product_cost_per_unit_updated') ?>

    <?php // echo $form->field($model, 'product_discount') ?>

    <?php // echo $form->field($model, 'product_weight') ?>

    <?php // echo $form->field($model, 'product_stock_alert') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'product_status') ?>

<!--
    <div class="form-group">
        <?php //Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
-->

    <?php ActiveForm::end(); ?>