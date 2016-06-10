<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'ปรับปรุงสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'สินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'แสดงกลุ่มสินค้า > '.$model->product_name, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'ปรับปรุงสินค้า';
?>
<div class="product-update">

    <h2><i class="fa fa-cube" aria-hidden="true"></i> <?= Html::decode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>