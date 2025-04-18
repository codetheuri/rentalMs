<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\Property $model */

$this->title = 'Update Property: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="property-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
