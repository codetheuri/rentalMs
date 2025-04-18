<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use dashboard\models\Unit;
use dashboard\models\Status;
use dashboard\models\Tenancy;
use Yii;

/** @var yii\web\View $this */
/** @var dashboard\models\MaintenanceRequest $model */
/** @var helpers\widgets\ActiveForm $form */

$loggedInUser = Yii::$app->user->identity;
$tenantId = $loggedInUser->user_id;
$username = $loggedInUser->username;

// Fetch only units linked to this tenant
$unitIds = Tenancy::find()
    ->select('unit_id')
    ->where(['tenant_id' => $tenantId])
    ->column();
$units = Unit::find()->where(['id' => $unitIds])->all();
?>

<div class="maintenance-request-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Unit Info
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'unit_id')->dropDownList(
                        ArrayHelper::map($units, 'id', 'unit_number'),
                        ['prompt' => 'Select Your Unit']
                    ) ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    Description
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'description')->textarea([
                        'rows' => 8,
                        'placeholder' => 'Describe the issue in detail...'
                    ]) ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    Tenant Info
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'tenant_id')->hiddenInput(['value' => $tenantId])->label(false) ?>
                    <div class="form-group">
                        <label class="control-label">Tenant</label>
                        <input type="text" class="form-control" value="<?= Html::encode($username) ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    Request Meta
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'status_id')->dropDownList(
                        ArrayHelper::map(Status::find()->all(), 'id', 'name'),
                        ['prompt' => 'Select Status']
                    ) ?>

                    <?= $form->field($model, 'requested_at')->widget(DatePicker::class, [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select request date...'
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="text-center mt-3">
        <?= Html::submitButton('Save Request', ['class' => 'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
