<?php

use helpers\Html;
use helpers\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dashboard\models\Unit;
use Auth\models\User; // adjust this if your User model is in a different namespace

/** @var yii\web\View $this */
/** @var dashboard\models\Tenancy $model */
/** @var helpers\widgets\ActiveForm $form */
$occupiedUnitIds = \dashboard\models\Tenancy::find()
    ->select('unit_id')
    ->where([
        'or',
        ['end_date' => null],
        ['>=', 'end_date', date('Y-m-d')]
    ])
    ->column();

// Include the current unit in case of update
$currentUnitId = $model->unit_id;

$vacantUnitsQuery = Unit::find()
    ->where([
        'or',
        ['not in', 'id', $occupiedUnitIds],
        ['id' => $currentUnitId] // Allow currently selected unit even if it's technically occupied
    ]);

$vacantUnits = $vacantUnitsQuery->all();

?>

<div class="tenancy-form">
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
    <div class="row">

        <!-- UNIT DROPDOWN -->
        <div class="col-md-12">
            <?= $form->field($model, 'unit_id')->dropDownList(
                ArrayHelper::map($vacantUnits, 'id', function ($unit) {
                    return 'Unit #' . $unit->unit_number . ' (Property : ' . $unit->property_id . ')';
                }),
                ['prompt' => 'Select Vacant Unit']
            ) ?>
        </div>
        <div class="col-md-12">
            <label>Monthly Rent</label>
            <input type="text" id="monthly-rent-display" class="form-control" readonly>
        </div>


        <!-- TENANT DROPDOWN (FROM USER TABLE) -->
        <div class="col-md-12">
            <?= $form->field($model, 'tenant_id')->dropDownList(
                ArrayHelper::map(
                    User::find()->all(), // filter by role if needed
                    'id',
                    function ($user) {
                        return $user->username; // or $user->full_name if available
                    }
                ),
                ['prompt' => 'Select Tenant username']
            ) ?>
        </div>

        <!-- START DATE -->
        <div class="col-md-12">
            <?= $form->field($model, 'start_date')->input('date') ?>
        </div>

        <!-- END DATE -->
        <!-- END DATE -->
        <div class="col-md-12">
            <?= $form->field($model, 'end_date')->input('date', ['readonly' => true, 'id' => 'end-date']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'payment_status')->dropDownList(
                \dashboard\models\Tenancy::getPaymentStatusList(),
                ['prompt' => 'Select status']
            ) ?>
        </div>

    </div>

    <div class="block-content block-content-full text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$units = \dashboard\models\Unit::find()->select(['id', 'monthly_rent'])->asArray()->all();
$unitRentMap = json_encode(ArrayHelper::map($units, 'id', 'monthly_rent'));
$this->registerJs("
    const rentMap = $unitRentMap;
    $('#tenancy-unit_id').on('change', function() {
        const unitId = $(this).val();
        const rent = rentMap[unitId] || '';
        $('#monthly-rent-display').val(rent);
    });
    
    // Trigger change on load if value exists
    $('#tenancy-unit_id').trigger('change');
");
?>
<?php
$this->registerJs(<<<JS
    $('#tenancy-start_date').on('change', function() {
        const startDate = new Date($(this).val());
        if (!isNaN(startDate.getTime())) {
            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + 1);

            // Adjust for month overflow (e.g., Jan 31 -> Feb 31 -> Mar 3)
            if (startDate.getDate() !== endDate.getDate()) {
                endDate.setDate(0); // Go to last day of previous month
            }

            const formatted = endDate.toISOString().split('T')[0];
            $('#end-date').val(formatted);
        }
    });

    // Trigger on page load if start_date is prefilled
    $('#tenancy-start_date').trigger('change');
JS);
?>