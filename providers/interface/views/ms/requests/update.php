<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\MaintenanceRequest $model */

$this->title = 'Update Maintenance Request: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Maintenance Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="maintenance-request-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
