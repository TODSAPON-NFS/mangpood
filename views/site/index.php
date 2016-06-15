<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\jui\DatePicker;

$this->title = 'Mangpood Management System';
$this->registerCssFile("@web/css/site.index.css");
$this->registerJs('
    
$("#site-index-pipeline-h2").on("click", function(){

    $("#site-index-pipeline").toggleClass("pipeline-expand");

});

', \yii\web\View::POS_READY);
?>
<div class="site-index">

    <div class="row">
        <div class="col-sm-12">
            <div id="site-index-pipeline" class="well well-md pipeline-shrink">

                <h2 style="display:inline;" id="site-index-pipeline-h2"><i class="fa fa-table" aria-hidden="true" style="vertical-align: baseline;"></i> <?= Html::encode("Pipeline") ?></h2>

                


            </div>

        </div>
    </div>



</div>