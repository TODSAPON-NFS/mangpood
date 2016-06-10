<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Csa */

$this->title = 'ปรับปรุงรายการลูกค้า คู่ค้า และพันธมิตรธุรกิจ';
$this->params['breadcrumbs'][] = ['label' => 'CSA', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'แสดง CSA > '.$model->csa_name_surname, 'url' => ['view', 'id' => $model->csa_id]];
$this->params['breadcrumbs'][] = 'ปรับปรุง CSA';
?>
<div class="csa-update">

    <h2><i class="fa fa-users" aria-hidden="true"></i> <?= Html::decode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
