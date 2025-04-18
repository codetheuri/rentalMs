<?php

use yii\helpers\Html;
use dashboard\models\Unit;
use dashboard\models\Property;
use Auth\models\User;

/** @var yii\web\View $this */
/** @var dashboard\models\Tenancy[] $tenancies */

$this->title = "All Tenancy Receipts";

?>

<div style="font-family: Arial, sans-serif;">
    <?php foreach ($tenancies as $model): ?>
        <?php
        $unit = Unit::findOne($model->unit_id);
        $property = $unit ? $unit->property : null;
        $tenant = User::findOne($model->tenant_id);
        $paid = $model->payment_status === 1 ? 'Paid' : 'Unpaid';

        ?>

        <div style="max-width: 800px; margin: 40px auto; page-break-after: always;">
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
        </div>
    <?php endforeach; ?>

    <div style="text-align: center;">
        <button onclick="window.print()">🖨️ Print All Receipts</button>
    </div>
</div>
<?php
$this->registerCss("
  @media print {
    /* Hide headers, navbars, buttons */
    .block-header,
    .btn,
    .block-options,
    .nav,
    .sidebar,
    .pagination,
    .breadcrumb,
    footer,
    .no-print {
      display: none !important;
    }

    /* Remove background colors */
    body,
    .card,
    .block,
    .block-content,
    .container,
    .table,
    .tenancy-index,
    .block-rounded {
      background: #fff !important;
      color: #000 !important;
      box-shadow: none !important;
    }

    /* Optimize tables */
    table {
      border: 1px solid #000 !important;
    }

    th, td {
      border: 1px solid #000 !important;
      padding: 8px !important;
    }

    /* Ensure full width */
    html, body {
      width: 100%;
      margin: 0;
      padding: 0;
    }
  }
");
?>
