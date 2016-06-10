<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Csa */

$this->title = 'เพิ่มลูกค้า คู่ค้า และพันธมิตรธุรกิจใหม่';
$this->params['breadcrumbs'][] = ['label' => 'CSA', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="csa-create">

    <h2><i class="fa fa-users" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
