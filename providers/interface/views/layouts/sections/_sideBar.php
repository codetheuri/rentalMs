<?php

use helpers\Html;
use ui\bundles\DashboardAsset;
use yii\helpers\Url;

DashboardAsset::register($this);
?>
<?php
// $user = Yii::$app->user;
// $isSuperAdmin = $user->can('su');
// $isOwner = $user->can('su');
// $isTenant = $user->can('su');
?>

<nav id="sidebar" aria-label="Main Navigation" class="sidebar">
    <div class="  text-center py-3">
        <a href="<?= Yii::$app->urlManager->createUrl(['dashboard/site/dashboard']) ?>" class="d-flex align-items-center justify-content-center">

            <?= Html::img('@web/providers/interface/assets/images/rental4.jpeg', [
                'alt' => 'RentalMS ',
                'class' => 'img-fluid',
                'style' => '
            max-height: 50%;
             margin-right: 10px;
            max-width: 50%;
            border-radius: 50%;
            padding-bottom: -50px;
             
             
             ', // adjust size here
            ]) ?>

        </a>
    </div>
    <!-- Side Header -->
    <div class="content-side">
        <!-- Logo -->
        <a class="fw-semibold text-dual" href="#">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-1 tracking-wider"><?= Yii::$app->name ?></span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>


        <!-- END Extra -->
    </div>
    <div class="js-sidebar-scroll">



        <div class="nav-main-item">
            

         
                <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/site/dashboard']) ?>">
                    <i class="nav-main-link-icon fa fa-home"></i>
                    <span class="nav-main-link-name">Dashboard</span>
                </a>
        
                <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/status/index']) ?>">
                    <i class="nav-main-link-icon fa fa-eye"></i>
                    <span class="nav-main-link-name">Status</span>
                </a>
      
        </div>
      
            <div class="nav-main-item">
                <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/property/index']) ?>">
                    <i class="nav-main-link-icon fa fa-building"></i>
                    <span class="nav-main-link-name">Properties</span>
                </a>
            </div>
   
     
            <div class="nav-main-item">
                <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/unit/index']) ?>">
                    <i class="nav-main-link-icon fa fa-door-open"></i>
                    <span class="nav-main-link-name">Units</span>
                </a>
            </div>


      
            <div class="nav-main-item">
                <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/tenancy/index']) ?>">
                    <i class="nav-main-link-icon fa fa-users"></i>
                    <span class="nav-main-link-name">Tenants</span>
                </a>
            </div>
     

        <div class="nav-main-item">
            <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/management-request/index']) ?>">
                <i class="nav-main-link-icon fa fa-tools"></i>
                <span class="nav-main-link-name">Maintenance</span>
            </a>
        </div>

        <div class="nav-main-item">
            <a class="nav-main-link" href="<?= Yii::$app->urlManager->createUrl(['dashboard/billing/index']) ?>">
                <i class="nav-main-link-icon fa fa-money-bill-wave"></i>
                <span class="nav-main-link-name">Billing</span>
            </a>
        </div>



        <!-- Side Navigation -->
        <div class="content-side">
            <?= \helpers\Menu::load() ?>
        </div>
    </div>
</nav>