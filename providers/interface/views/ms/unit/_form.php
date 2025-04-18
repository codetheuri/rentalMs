<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dashboard\models\Property; // adjust namespace if needed
use dashboard\models\Status;   // adjust namespace if needed
use Yii;

/** @var yii\web\View $this */
/** @var dashboard\models\Unit $model */
/** @var helpers\widgets\ActiveForm $form */

$userId = Yii::$app->user->id;

// Fetch only properties belonging to this user (for owners)
$propertyOptions = ArrayHelper::map(
    Property::find()->where(['owner_id' => $userId])->all(),
    'id',
    'name'
);

$statusOptions = ArrayHelper::map(Status::find()->all(), 'id', 'name');
?>

<div class="unit-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    <div class="row">

        <div class="col-md-12">
            <!-- Dropdown of user-owned properties -->
            <?= $form->field($model, 'property_id')->dropDownList(
                $propertyOptions,
                ['prompt' => 'Select Property']
            ) ?>
        </div>
        

        <div class="col-md-12">
            <?= $form->field($model, 'unit_number')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'monthly_rent')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <!-- Dropdown of status names -->
            <?= $form->field($model, 'status_id')->dropDownList(
                $statusOptions,
                ['prompt' => 'Select Status']
            ) ?>
        </div>
    </div>

    <div class="block-content block-content-full text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
