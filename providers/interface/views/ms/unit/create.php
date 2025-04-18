<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var dashboard\models\Unit $model */

$this->title = 'Create Unit';
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
