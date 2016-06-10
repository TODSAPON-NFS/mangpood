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

    <?php //$form->field($model, 'csa_id') ?>

    <?php //$form->field($model, 'csa_type') ?>

    <?php //$form->field($model, 'csa_name') ?>

    <?php //$form->field($model, 'csa_surname') ?>

    <?php //$form->field($model, 'csa_company') ?>

    <?php // echo $form->field($model, 'csa_email') ?>

    <?php // echo $form->field($model, 'csa_phone') ?>

    <?php // echo $form->field($model, 'csa_socialmedia') ?>

    <?php // echo $form->field($model, 'csa_province_id') ?>

    <?php // echo $form->field($model, 'csa_zipcode_id') ?>

    <?php // echo $form->field($model, 'csa_address') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

<!--
    <div class="form-group">
        <?php //Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
-->

    <?php ActiveForm::end(); ?>