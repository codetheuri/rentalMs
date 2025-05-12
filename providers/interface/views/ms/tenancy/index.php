<?php

use dashboard\models\Tenancy;
use helpers\Html;
// use yii\helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;
use ui\bundles\DashboardAsset;

DashboardAsset::register($this);

/** @var yii\web\View $this */
/** @var dashboard\models\searches\TenancySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tenancies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenancy-index row">
  <div class="col-md-12">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>

        <div class="d-flex gap-2 flex-wrap">

          <?= Html::customButton([
            'type' => 'link',
            'url' => Url::to(['tenancy/summary']),
            'appearence' => [
              'class' => 'btn btn-outline-info shadow-sm rounded-pill px-3 py-2 fw-bold',
              'target' => '_blank',
              'type' => 'text',
              'text' =>  '📊 Financial Summary',
              'visible' => Yii::$app->user->can('dashboard-tenancy-create', true),
              'icon' => 'chart-bar',
            ],
            'link' => ['title' => 'Summary']
          ]) ?>

          <?= Html::customButton([
            'type' => 'link',
            'url' => Url::to(['tenancy/receipts']),
            'appearence' => [
              'class' => 'btn btn-outline-primary shadow-sm rounded-pill px-3 py-2 fw-bold',
              'target' => '_blank',
              'type' => 'text',
              'text' =>  '📄 Print All Receipts',
              'visible' => Yii::$app->user->can('dashboard-tenancy-create', true),
              'icon' => 'print'
            ],
            'link' => ['title' => 'Print Receipts']
          ]) ?>

        </div>


        <div class="block-options">
          <?= Html::customButton([
            'type' => 'modal',
            'url' => Url::to(['create']),
            'appearence' => [
              'type' => 'text',
              'text' => 'Create Tenancy',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('dashboard-tenancy-create', true)
            ],
            'modal' => ['title' => 'New Tenancy']
          ]) ?>
        </div>
      </div>
      <div class="block-content">
        <div class="tenancy-search my-3">
          <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>


        <?php if (Yii::$app->user->can('dashboard-tenancy-create', false)) : ?>
        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'attribute' => 'unit_id',
              'value' => function ($model) {
                return $model->unit ? $model->unit->unit_number : null;
              },
              'label' => 'Unit',
            ],

          
            Yii::$app->user->can('dashboard-tenancy-create', true) ? [
              'attribute' => 'tenant_id',
              'value' => function ($model) {
                return $model->tenant ? $model->tenant->username : null;
              },
              'label' => 'Tenant',
            ] : [
              'label' => 'Tenant',
              'value'=> "not allowed",
              'visible' => false
            ],

            'start_date',

            'end_date',
            [
              'label' => 'Monthly Rent',
              'value' => function ($model) {
                return $model->unit ? ($model->unit->monthly_rent) . ' Ksh' : null;
              },
            ],

            Yii::$app->user->can('dashboard-tenancy-create', true) ? [
              'attribute' => 'payment_status',
              'format' => 'raw',
              'label' => 'Payment Status',
              'value' => function ($model) {

                $status = $model->payment_status == 1 ? 'Paid' : 'Unpaid';
                $color = $model->payment_status == 1 ? 'green' : 'red';

                return "<span style='background: {$color}; color: white; padding: 4px 8px; border-radius: 4px;'>{$status}</span>";
              },
            ]: [
              'label' => 'Payment Status',
              'value'=> "not allowed",
              'visible' => false
            ],


            //'is_deleted',
            //'created_at',
            //'updated_at',

            [
              'class' => \helpers\grid\ActionColumn::className(),
              'template' => '{update} {trash} {receipt}',
              'headerOptions' => ['width' => '8%'],
              'contentOptions' => ['style' => 'text-align: center;'],
              'buttons' => [
                'update' => function ($url, $model, $key) {
                  return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Tenancy'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                },
                'receipt' => function ($url, $model, $key) {
                  return Html::customButton(['type' => 'link', 'url' => Url::toRoute(['receipt', 'id' => $model->id]), 'modal' => ['title' => 'Rental Receipt'], 'appearence' => ['icon' => 'book', 'theme' => 'success']]);
                },
                'trash' => function ($url, $model, $key) {
                  return $model->is_deleted !== 1 ?
                    Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this tenancy?']]]) :
                    Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this tenancy?']]]);
                },
              ],
              'visibleButtons' => [
                'update' => Yii::$app->user->can('dashboard-tenancy-update', true),
                'receipt' => function ($model) {
                  return $model->payment_status == 1 ? Yii::$app->user->can('dashboard-tenancy-update', true) : false;
                },

                'trash' => function ($model) {
                  return $model->is_deleted !== 1 ?
                    Yii::$app->user->can('dashboard-tenancy-delete', true) :
                    Yii::$app->user->can('dashboard-tenancy-restore', true);
                },
              ],
            ],

          ],

        ]); ?>
        <?php else : ?>
        <div class="alert alert-warning">You do not have permission to  tenancies.</div>
        <?php endif; ?>


      </div>
    </div>
  </div>
</div>