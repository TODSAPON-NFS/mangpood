<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax; //สำหรับเรียกใช้ Pjax (Ajax เฉพาะส่วน)

$this->title = 'เข้าสู่ระบบ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/login.php.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="site-login">

    <h1 style="text-align: center;margin-bottom: 25px;"><b><i class="fa fa-lock" aria-hidden="true" style="color:#ff6600;font-size:1em;vertical-align: baseline;"></i> <?= Html::encode($this->title) ?></b></h1>

    <?php Pjax::begin(); ?>

    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" style="border: 2px solid #ff6600;border-radius: 20px;margin:0px 20px;">

            <?php if (Yii::$app->session->getFlash('invalidUsernamePassword')) : ?>
                <div class="alert alert-danger fade in" style="margin: 20px 0px 0px 0px;padding:10px 20px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i> <?php echo Yii::$app->session->getFlash('invalidUsernamePassword'); ?>
                </div>
            <?php endif; ?>

            <?php
            //สำหรับฟอร์ม สิ่งสำคัญอยู่ที่ "options" => ["data-pjax" => ""] ไม่งั้น Pjax (Ajax) ไม่ทำงาน

            $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['data-pjax' => '', 'class' => 'form-horizontal', 'style' => 'padding: 20px 10px 0px 0px;'],
                        'fieldConfig' => [
                            'template' => "{label}<div class=\"col-sm-8\">{input}<strong>{error}</strong></div>",
                            'labelOptions' => ['class' => 'col-sm-4 control-label'],
                        ],
            ]);
            ?>

            <?= $form->field($model, 'user_name')->textInput(['autofocus' => true, 'style' => 'margin:0px']) ?>

            <?= $form->field($model, 'user_password')->passwordInput(['style' => 'margin:0px']) ?>

            <?php echo
            $form->field($model, 'rememberMe')->checkbox([
                'template' => '<div class="col-sm-offset-4 col-sm-8">{input} {label}</div>', 
                'style' => 'margin:0px;'
            ]);

            echo $form->field($model, 'dateRememberMe', [
                'inputTemplate' => '<div class="col-sm-4 input-group">{input}<span class="input-group-addon">วัน</span></div>'
            ])->input('number',[
                'min' => 1,
                'max' => 365,
                'maxlength' => 3,
            ])->label('');


            
 /*           echo $form->field($model, 'dateRememberMe')->inline()->radioList([1=>'1 วัน',7=>'1 สัปดาห์', 15 =>'15 วัน', 30=>'30 วัน']);*/

            ?>

            <div class="form-group-sm">
                <div class="" style="margin-top:0px; padding: 10px 0px 20px 0px;text-align: center;">
<?= Html::submitButton('ลงชื่อเข้าใช้งาน', ['class' => 'btn btn-info', 'name' => 'login-button', 'style' => 'font-weight:bolder;margin:0px;']) ?>
                </div>
            </div>

<?php ActiveForm::end(); ?>

        </div>
        <div class="col-sm-3"></div>

<?php Pjax::end();  ?>


    </div>
</div>
