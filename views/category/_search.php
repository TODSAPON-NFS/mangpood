<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */

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

            <?php
            /*
              echo $form->field($model, 'category_id');
              echo $form->field($model, 'category_name');
              echo $form->field($model, 'category_created_at');
              echo $form->field($model, 'category_updated_at');
             */
            ?>


            <?php
            /*
              echo Html::submitButton('Search', ['class' => 'btn btn-primary']);
              echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
             * 
             */
            ?>


            <?php ActiveForm::end(); ?>