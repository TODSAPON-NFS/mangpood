<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'ปรับปรุงกลุ่มสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'กลุ่มสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'แสดงกลุ่มสินค้า > '.$model->category_name, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'ปรับปรุงกลุ่มสินค้า';
?>
<div class="category-update">

    <h2><i class="fa fa-cubes" aria-hidden="true"></i> <?= Html::decode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>