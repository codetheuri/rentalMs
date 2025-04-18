<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\MaintenanceRequest $model */

$this->title = 'Create Maintenance Request';
$this->params['breadcrumbs'][] = ['label' => 'Maintenance Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-request-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
