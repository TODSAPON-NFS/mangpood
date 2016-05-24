<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="jumbotron" >
        
        <div class="row">

        <div class="col-md-9">
            
            <h1 style="font-weight:bolder;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h1>
            
            <h4 class="alert alert-danger"><?= nl2br(Html::encode($message)) ?></h4>
            <h5>ความผิดพลาดเกิดขึ้นในขณะที่ระบบให้บริการกำลังประมวลผลการร้องขอ (Request)</h5>
            <h5 style="margin-bottom:20px;">โปรดติดต่อเราหากท่านมั่นใจว่าเกิดจากความผิดพลาดของระบบให้บริการ</h5>

        </div>
        <div class="col-md-3" style="margin-bottom: 0px;">
            <?= Html::img('@web/images/nong_mangpood_error.png', ['class'=>'hidden-xs pull-right']); ?>
        </div>

    </div>
        
    </div>

</div>
