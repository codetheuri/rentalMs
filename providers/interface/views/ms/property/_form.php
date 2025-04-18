<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dashboard\models\Status; // Adjust to your namespace if needed
use Yii;

/** @var yii\web\View $this */
/** @var dashboard\models\Property $model */
/** @var helpers\widgets\ActiveForm $form */

?>

<div class="property-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
  <?= $form->field($model, 'number_of_units')->textInput(['type' => 'number', 'min' => 1]) ?>
</div>
        <div class="col-md-12">
            <?= $form->field($model, 'monthly_rent')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
        </div>

        <div class="col-md-12">
            <!-- Prefill owner_id with logged-in user -->
            <?= $form->field($model, 'owner_id')->hiddenInput([
                'value' => Yii::$app->user->id
            ])->label(false) ?>
        </div>

        <div class="col-md-12">
            <!-- Dropdown for status using status name -->
            <?= $form->field($model, 'status_id')->dropDownList(
                ArrayHelper::map(Status::find()->all(), 'id', 'name'),
                ['prompt' => 'Select Status']
            ) ?>
        </div>
    </div>

    <div class="block-content block-content-full text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
