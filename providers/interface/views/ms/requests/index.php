<?php

use dashboard\models\MaintenanceRequest;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var dashboard\models\searches\RequestSearches $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Maintenance Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-request-index row">
    <div class="col-md-12">
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>
          <div class="block-options">
          <?=  Html::customButton([
            'type' => 'modal',
            'url' => Url::to(['create']),
            'appearence' => [
              'type' => 'text',
              'text' => 'Create Maintenance Request',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('dashboard-management-request-create', true)
            ],
            'modal' => ['title' => 'New Maintenance Request']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="maintenance-request-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

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
            [
                'attribute' => 'tenant_id',
                'value' => function ($model) {
                    return $model->tenant ? $model->tenant->username : null;
                },
                'label' => 'Tenant',
            ],
        
            'description:ntext',
            [
              'attribute' => 'status_id',
              'format' => 'raw', // IMPORTANT to render HTML
              'label' => 'Status',
              'value' => function ($model) {
                  if (!$model->status) return null;
          
                  $name = $model->status->name;
          
                  // Define color classes for each status
                  $colors = [
                      'Available' => 'green',
                      'Occupied' => 'red',
                      'Pending Approval' => 'orange',
                      'Active' => 'blue',
                      'Inactive' => 'gray',
                      'Resolved' => 'teal',
                      'In Progress' => 'purple',
                      'vacant' => 'limegreen',
                  ];
          
                  $color = $colors[$name] ?? 'black';
          
                  return "<span style='background: {$color}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 13px;'>{$name}</span>";
              }
          ],
            //'is_deleted',
            //'requested_at',
            //'resolved_at',
            //'created_at',
            //'updated_at',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Maintenance Request'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this maintenance request?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this maintenance request?']]]);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('dashboard-management-request-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('dashboard-management-request-delete',true) : 
                                Yii::$app->user->can('dashboard-management-request-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>