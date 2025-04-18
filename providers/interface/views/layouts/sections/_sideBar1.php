<?php
use yii\helpers\Html;
use ui\bundles\DashboardAsset;
DashboardAsset::register($this);
?>
<nav id="sidebar" aria-label="Main Navigation" class="sidebar">
<div class="js-sidebar-scroll">
    <!-- Side Navigation -->
    <ul class="nav-main">
        <li class="nav-item">
            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/index']) ?>">
                <i class="nav-icon fa fa-home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['property/index']) ?>">
                <i class="nav-icon fa fa-building"></i>
                <span class="nav-text">Properties</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['unit/index']) ?>">
                <i class="nav-icon fa fa-door-open"></i>
                <span class="nav-text">Units</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['tenant/index']) ?>">
                <i class="nav-icon fa fa-users"></i>
                <span class="nav-text">Tenants</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['maintenance-request/index']) ?>">
                <i class="nav-icon fa fa-tools"></i>
                <span class="nav-text">Maintenance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['user/index']) ?>">
                <i class="nav-icon fa fa-user-cog"></i>
                <span class="nav-text">Users</span>
            </a>
        </li>
    </ul>
</div>
</nav>
