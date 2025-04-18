<?php
use helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii;
?>

<div class="billing-index">
    <h1>Payment History</h1>

    <p>
        <?= Html::customButton([
            'type' => 'modal',
            'url' => Url::to(['payment']),
            'appearence' => [
                'type' => 'text',
                'text' => 'Make New Payment',
                'theme' => 'success',
            ],
            'modal' => ['title' => 'Make Payment'],
           'visible'=> Yii::$app->user->can('dashboard-billing-payment',true) 
        ])
           ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => \dashboard\models\Payments::find()->orderBy(['created_at' => SORT_DESC]),
        ]),
        'columns' => [
            'id',
            'amount',
            'transaction_id',
            // 'status',
            // 'created_at',
        ],
    ]); ?>
</div>