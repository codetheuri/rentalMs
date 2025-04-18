<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\Tenancy $model */

$this->title = 'Create Tenancy';
$this->params['breadcrumbs'][] = ['label' => 'Tenancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenancy-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
