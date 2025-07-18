<?php

namespace dashboard\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\models\Tenancy;
use Yii;

/**
 * TenancySearch represents the model behind the search form of `dashboard\models\Tenancy`.
 */
class TenancySearch extends Tenancy
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'unit_id', 'tenant_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            ['globalSearch', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

     public function search($params)
{
    $query = Tenancy::find()->where(['tenancy.is_deleted' => 0]);
    // $query =Tenancy::find()->all();

    $currentUser = \Yii::$app->user;
    // $query = Tenancy::find();
    // 🔒 Filter for Property Owner - show tenancies of their units only
    if ($currentUser->can('dashboard-property-create')) {
            // $query = Tenancy::find();
            // $ownerId = Yii::$app->user->identity->id; 
            $query->joinWith(['unit.property'])
                  ->andWhere(['property.owner_id' => $currentUser->id]);
        }
    elseif ($currentUser->can('dashboard-tenancy-delete')) {
        $query = Tenancy::find(); // Changed from ->all() to just find()
        // $query->joinWith(['unit.property'])
        //       ->andWhere(['property.owner_id' => $currentUser->id]);
    }
    // elseif ($currentUser->can('dashboard-property-create')) {
    //     // $query = Tenancy::find();
    //     // $ownerId = Yii::$app->user->identity->id; 
    //     $query->joinWith(['unit.property'])
    //           ->andWhere(['property.owner_id' => $currentUser->id]);
    // }

    // // 🔒 Filter for Tenant - show only their own tenancy
    elseif ($currentUser->can('tenant')) {
        $query->andWhere(['tenant_id' => $currentUser->id]);
    }

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'defaultPageSize' => \Yii::$app->params['defaultPageSize'],
            'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]
        ],
        'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
    ]);

    $this->load($params);

    if (!$this->validate()) {
        $query->where('0=1');
        return $dataProvider;
    }

    // 🔍 Global search
    if (isset($this->globalSearch)) {
        $query->orFilterWhere([
            'id' => $this->globalSearch,
            'unit_id' => $this->globalSearch,
            'tenant_id' => $this->globalSearch,
            'start_date' => $this->globalSearch,
            'end_date' => $this->globalSearch,
         'tenancy.is_deleted' => $this->globalSearch,

            'created_at' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);
    } else {
        $query->andFilterWhere([
            'id' => $this->id,
            'unit_id' => $this->unit_id,
            'tenant_id' => $this->tenant_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_deleted' => $this->is_deleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }

    return $dataProvider;
}

    // public function search($params)
    // {
    //     $query = Tenancy::find();

    //     // add conditions that should always apply here

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //         'pagination' => [ 'defaultPageSize' => \Yii::$app->params['defaultPageSize'], 'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]],
    //         'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         $query->where('0=1');
    //         return $dataProvider;
    //     }

    //     // grid filtering conditions
    //     if(isset($this->globalSearch)){
    //             $query->orFilterWhere([
    //         'id' => $this->globalSearch,
    //         'unit_id' => $this->globalSearch,
    //         'tenant_id' => $this->globalSearch,
    //         'start_date' => $this->globalSearch,
    //         'end_date' => $this->globalSearch,
    //         'is_deleted' => $this->globalSearch,
    //         'created_at' => $this->globalSearch,
    //         'updated_at' => $this->globalSearch,
    //     ]);
    //     }else{
    //             $query->andFilterWhere([
    //         'id' => $this->id,
    //         'unit_id' => $this->unit_id,
    //         'tenant_id' => $this->tenant_id,
    //         'start_date' => $this->start_date,
    //         'end_date' => $this->end_date,
    //         'is_deleted' => $this->is_deleted,
    //         'created_at' => $this->created_at,
    //         'updated_at' => $this->updated_at,
    //     ]);
    //     }
    //     return $dataProvider;
    // }
}
