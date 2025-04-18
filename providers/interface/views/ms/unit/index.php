<?php

use dashboard\models\Unit;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var dashboard\models\searches\UnitSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Units';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index row">
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
              'text' => 'Create Unit',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('dashboard-unit-create', true)
            ],
            'modal' => ['title' => 'New Unit']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="unit-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          
           
            [
              'attribute' => 'property_id',
              'value' => function ($model) {
                  return $model->property ? $model->property->name : null;
              },
              'label' => 'Property',
            ],
            'unit_number',
            'monthly_rent',
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
          
            // [
            //   'attribute' => 'tenant_id',
            //   'value' => function ($model) {
            //       return $model->tenant ? $model->tenant->username : null;
            //   },
            //   'label' => 'Tenant',

            // ],
          
            //'is_deleted',
            //'created_at',
            //'updated_at',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Unit'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this unit?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this unit?']]]);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('dashboard-unit-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('dashboard-unit-delete',true) : 
                                Yii::$app->user->can('dashboard-unit-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>