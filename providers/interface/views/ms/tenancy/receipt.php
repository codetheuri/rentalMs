<?php

use yii\helpers\Html;
use dashboard\models\Tenancy;
use dashboard\models\Unit;
use dashboard\models\Property;
use Auth\models\User;

/** @var yii\web\View $this */
/** @var dashboard\models\Tenancy $model */

$this->title = "Tenancy Receipt";

$unit = Unit::findOne($model->unit_id);
$property = $unit ? $unit->property : null;
$tenant = User::findOne($model->tenant_id);
$paid = $model->payment_status === 1 ? 'Paid' : 'Unpaid';
?>

<div style="max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif;">
    <h2 style="text-align: center;">Rental Receipt</h2>
    <hr>

    <p><strong>Tenant:</strong> <?= Html::encode($tenant->username ?? '-') ?></p>
    <p><strong>Property:</strong> <?= Html::encode($property->name ?? '-') ?></p>
    <p><strong>Unit Number:</strong> <?= Html::encode($unit->unit_number ?? '-') ?></p>
    <p><strong>Start Date:</strong> <?= Yii::$app->formatter->asDate($model->start_date) ?></p>
    <p><strong>End Date:</strong> <?= Yii::$app->formatter->asDate($model->end_date) ?></p>
    <p><strong>Monthly Rent:</strong> <?= ($unit->monthly_rent ?? 0) ?> Ksh</p>
    <p><strong>Payment Status:</strong> <?= Html::encode($paid) ?></p>

    <hr>
    <p style="text-align: right;">Generated on <?= Yii::$app->formatter->asDatetime(time()) ?></p>

    <div style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()">🖨️ Print Receipt</button>
    </div>
</div>
