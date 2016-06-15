<?php

use yii\helpers\Html;

$this->title = 'ลงบันทึกเหตุการณ์ (Pipeline)';
$this->params['breadcrumbs'][] = ['label' => 'Pipeline', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pipeline-create">

    <h2><i class="fa fa-table" aria-hidden="true"></i> <?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>