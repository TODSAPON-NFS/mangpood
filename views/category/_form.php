<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form" style="margin-top:20px;">

    <div class="row">
        <div class="col-sm-6">

            <?php
            $form = ActiveForm::begin([
                        'enableAjaxValidation' => true,
                        'fieldConfig' => [
                            'template' => '{label}<div class=\"col-sm-8\">{input}<strong>{error}</strong></div>',
                            'labelOptions' => ['class' => 'control-label'],
                        ],
            ]);
            ?>

            <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]); ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-square fa-lg" aria-hidden="true" style="margin-right:7px;"></i>สร้างใหม่' : '<i class="fa fa-pencil-square" aria-hidden="true" style="margin-right:7px;"></i>ปรับปรุง', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
            </div>



            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
