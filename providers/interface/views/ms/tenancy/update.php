<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\Tenancy $model */

$this->title = 'Update Tenancy: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tenancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tenancy-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
