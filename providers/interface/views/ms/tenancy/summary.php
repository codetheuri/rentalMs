<?php
use yii\helpers\Html;

/** @var float $totalExpected */
/** @var float $totalPaid */
/** @var float $totalArrears */
/** @var array $arrearsList */

$this->title = "Tenancy Financial Summary";
?>

<div class="tenancy-summary" style="max-width: 900px; margin: auto; font-family: Arial;">
    <h2 style="text-align:center;">📊 Tenancy Financial Summary</h2>
    <hr>

    <div style="display: flex; justify-content: space-around; margin-bottom: 30px;">
        <div style="text-align: center;">
            <h3>💰 Total Expected</h3>
            <p><strong><?= Yii::$app->formatter->asCurrency($totalExpected) ?></strong></p>
        </div>
        <div style="text-align: center;">
            <h3>✅ Total Paid</h3>
            <p><strong><?= Yii::$app->formatter->asCurrency($totalPaid) ?></strong></p>
        </div>
        <div style="text-align: center;">
            <h3>❌ Total Arrears</h3>
            <p><strong><?= Yii::$app->formatter->asCurrency($totalArrears) ?></strong></p>
        </div>
    </div>

    <h4>🔻 Tenants With Arrears:</h4>

    <?php if (empty($arrearsList)): ?>
        <p>🎉 All tenants have paid!</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f1f1f1;">
                <tr>
                    <th>Tenant</th>
                    <th>Property</th>
                    <th>Unit</th>
                    <th>Amount Owed</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arrearsList as $item): ?>
                    <tr>
                        <td><?= Html::encode($item['tenant']) ?></td>
                        <td><?= Html::encode($item['property']) ?></td>
                        <td><?= Html::encode($item['unit']) ?></td>
                        <td><?= Html::encode($item['amount_due'])  ?> Ksh</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div style="text-align:center; margin-top: 30px;">
        <button onclick="window.print()">🖨️ Print Summary</button>
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

