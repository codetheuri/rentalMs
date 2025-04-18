<?php

namespace dashboard\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\models\MaintenanceRequest;

/**
 * RequestSearches represents the model behind the search form of `dashboard\models\MaintenanceRequest`.
 */
class RequestSearches extends MaintenanceRequest
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'unit_id', 'tenant_id', 'status_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['description', 'requested_at', 'resolved_at'], 'safe'],
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
        $query = MaintenanceRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'defaultPageSize' => \Yii::$app->params['defaultPageSize'], 'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if(isset($this->globalSearch)){
                $query->orFilterWhere([
            'id' => $this->globalSearch,
            'unit_id' => $this->globalSearch,
            'tenant_id' => $this->globalSearch,
            'status_id' => $this->globalSearch,
            'is_deleted' => $this->globalSearch,
            'requested_at' => $this->globalSearch,
            'resolved_at' => $this->globalSearch,
            'created_at' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['like', 'description', $this->globalSearch]);
        }else{
                $query->andFilterWhere([
            'id' => $this->id,
            'unit_id' => $this->unit_id,
            'tenant_id' => $this->tenant_id,
            'status_id' => $this->status_id,
            'is_deleted' => $this->is_deleted,
            'requested_at' => $this->requested_at,
            'resolved_at' => $this->resolved_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        }
        return $dataProvider;
    }
}
