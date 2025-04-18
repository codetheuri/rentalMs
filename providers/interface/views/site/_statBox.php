<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use helpers\DashboardAsset;
use helpers\grid\GridView;
?>
<div class="col-md-4 mb-4">
    <div class="card border-left-<?= $color ?> shadow h-100 py-2 rounded hover-shadow" style="transition: transform 0.2s;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <div class="text-xs font-weight-bold text-<?= $color ?> text-uppercase mb-1">
                    <?= Html::encode($label) ?>
                </div>
                <div class="h5 mb-0 font-weight-bold text-dark"><?= $count ?></div>
            </div>
            <i class="fas <?= $icon ?> fa-2x text-<?= $color ?>"></i>
        </div>
    </div>
</div>
