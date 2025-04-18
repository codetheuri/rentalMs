<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\Unit $model */

$this->title = 'Update Unit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unit-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
