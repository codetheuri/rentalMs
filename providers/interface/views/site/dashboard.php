<?php

use helpers\Html;
use dashboard\models\Property;
use dashboard\models\Unit;
use dashboard\models\Tenancy;
use dashboard\models\MaintenanceRequest;
use Auth\models\User;
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_END]);

// Stats
$totalProperties = Property::find()->count();
$totalUnits = Unit::find()->count();
$totalTenants = User::find()->count();
$occupiedUnits = Unit::find()->where(['status_id' => 2])->count(); // 2 = Occupied
$vacantUnits = Unit::find()->where(['status_id' => 8])->count();   // 8 = Vacant
$activeTenancies = Tenancy::find()->where(['not', ['end_date' => null]])->count();

$pendingRequests = MaintenanceRequest::find()->where(['status_id' => 3])->count(); // Pending
$inProgressRequests = MaintenanceRequest::find()->where(['status_id' => 7])->count();
$resolvedRequests = MaintenanceRequest::find()->where(['status_id' => 6])->count();

// Rent (for simplicity, monthly)
$totalExpectedRent = 0;
$totalUnpaid = 0;
$totalPaid = 0;
$tenancies = Tenancy::find()->all();
foreach ($tenancies as $tenancy) {
    $unit = $tenancy->unit;
    $rent = $unit->monthly_rent ?? 0;
    $totalExpectedRent += $rent;
    if ($tenancy->payment_status == 1) {
        $totalPaid += $rent;
    } else {
        $totalUnpaid += $rent;
    }
}
$monthlyTrends = Tenancy::find()
    ->select([
        "MONTH(start_date) as month",
        "SUM(CASE WHEN payment_status = 1 THEN unit.monthly_rent ELSE 0 END) AS paid_rent",
        "SUM(unit.monthly_rent) AS expected_rent"
    ])
    ->joinWith('unit')
    ->groupBy(["MONTH(start_date)"])
    ->orderBy(["month" => SORT_ASC])
    ->asArray()
    ->all();

?>


<div class="container-fluid">
<?= Html::a('⬇️ Export Tenancy CSV', ['export-csv'], ['class' => 'btn btn-outline-secondary']) ?>

    <div class="row">
        <?= $this->render('_statBox', ['label' => 'Properties', 'count' => $totalProperties, 'icon' => 'fa-building', 'color' => 'primary']) ?>
        <?= $this->render('_statBox', ['label' => 'Units', 'count' => $totalUnits, 'icon' => 'fa-home', 'color' => 'success']) ?>
        <?= $this->render('_statBox', ['label' => 'Tenants', 'count' => $totalTenants, 'icon' => 'fa-users', 'color' => 'info']) ?>
        <?= $this->render('_statBox', ['label' => 'Occupied Units', 'count' => $occupiedUnits, 'icon' => 'fa-door-closed', 'color' => 'secondary']) ?>
        <?= $this->render('_statBox', ['label' => 'Vacant Units', 'count' => $vacantUnits, 'icon' => 'fa-door-open', 'color' => 'warning']) ?>
        <?= $this->render('_statBox', ['label' => 'Active Tenancies', 'count' => $activeTenancies, 'icon' => 'fa-handshake', 'color' => 'dark']) ?>
    </div>

    <div class="row mt-4">
        <?= $this->render('_statBox', ['label' => 'Pending Requests', 'count' => $pendingRequests, 'icon' => 'fa-tools', 'color' => 'danger']) ?>
        <?= $this->render('_statBox', ['label' => 'In Progress', 'count' => $inProgressRequests, 'icon' => 'fa-sync', 'color' => 'info']) ?>
        <?= $this->render('_statBox', ['label' => 'Resolved Requests', 'count' => $resolvedRequests, 'icon' => 'fa-check-circle', 'color' => 'success']) ?>
    </div>

    <div class="row mt-4">
        <?= $this->render('_statBox', ['label' => 'Expected Rent', 'count' => Yii::$app->formatter->asCurrency($totalExpectedRent), 'icon' => 'fa-coins', 'color' => 'primary']) ?>
        <?= $this->render('_statBox', ['label' => 'Paid Rent', 'count' => Yii::$app->formatter->asCurrency($totalPaid), 'icon' => 'fa-money-bill', 'color' => 'success']) ?>
        <?= $this->render('_statBox', ['label' => 'Unpaid Rent', 'count' => Yii::$app->formatter->asCurrency($totalUnpaid), 'icon' => 'fa-exclamation-circle', 'color' => 'danger']) ?>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <h5>Recent Tenants</h5>
        <ul class="list-group">
            <?php foreach (User::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all() as $user): ?>
                <li class="list-group-item">
                    <i class="fas fa-user text-primary"></i> <?= Html::encode($user->username) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="col-md-6">
        <h5>Recent Maintenance</h5>
        <ul class="list-group">
            <?php foreach (MaintenanceRequest::find()->orderBy(['requested_at' => SORT_DESC])->limit(5)->all() as $request): ?>
                <li class="list-group-item">
                    <i class="fas fa-wrench text-warning"></i> <?= Html::encode($request->description) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<canvas id="rentChart" height="100"></canvas>

<?php
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun"];
$expected = [20000, 25000, 23000, 28000, 27000, 30000];
$paid = [18000, 20000, 21000, 25000, 26000, 28000];

$this->registerJs("
  const ctx = document.getElementById('rentChart');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: " . json_encode($months) . ",
      datasets: [{
        label: 'Expected Rent',
        data: " . json_encode($expected) . ",
        borderColor: 'rgba(54, 162, 235, 1)',
        fill: false
      },
      {
        label: 'Paid Rent',
        data: " . json_encode($paid) . ",
        borderColor: 'rgba(75, 192, 192, 1)',
        fill: false
      }]
    }
  });
");
?>

