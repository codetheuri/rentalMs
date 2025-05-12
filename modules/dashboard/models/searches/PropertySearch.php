<?php

namespace dashboard\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\models\Property;
use Yii;
/**
 * PropertySearch represents the model behind the search form of `dashboard\models\Property`.
 */
class PropertySearch extends Property
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'owner_id', 'status_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address', 'type', 'description'], 'safe'],
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
    // public function search($params)
    // {
    //     $query = Property::find();

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
    //         'owner_id' => $this->globalSearch,
    //         'status_id' => $this->globalSearch,
    //         'is_deleted' => $this->globalSearch,
    //         'created_at' => $this->globalSearch,
    //         'updated_at' => $this->globalSearch,
    //     ]);

    //     $query->orFilterWhere(['like', 'name', $this->globalSearch])
    //         ->orFilterWhere(['like', 'address', $this->globalSearch])
    //         ->orFilterWhere(['like', 'type', $this->globalSearch])
    //         ->orFilterWhere(['like', 'description', $this->globalSearch]);
    //     }else{
    //             $query->andFilterWhere([
    //         'id' => $this->id,
    //         'owner_id' => $this->owner_id,
    //         'status_id' => $this->status_id,
    //         'is_deleted' => $this->is_deleted,
    //         'created_at' => $this->created_at,
    //         'updated_at' => $this->updated_at,
    //     ]);

    //     $query->andFilterWhere(['like', 'name', $this->name])
    //         ->andFilterWhere(['like', 'address', $this->address])
    //         ->andFilterWhere(['like', 'type', $this->type])
    //         ->andFilterWhere(['like', 'description', $this->description]);
    //     }
    //     return $dataProvider;
    // }
    public function search($params)
{
    $query = Property::find()->where(['is_deleted' => 0]);
    $query = Property::find();

    // ✅ Restrict to current user if they are a property owner
    // if (\Yii::$app->user->can('dashboard-property-create')) {
    //     $query->andWhere(['owner_id' => \Yii::$app->user->id]);
    // }
    // elseif (\Yii::$app->user->can('dashboard-property-delete')){
    //     $query = Property::find();
    // }
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'defaultPageSize' => \Yii::$app->params['defaultPageSize'],
            'pageSizeLimit' => [1, \Yii::$app->params['pageSizeLimit']]
        ],
        'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
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
            'owner_id' => $this->globalSearch,
            'status_id' => $this->globalSearch,
            'is_deleted' => $this->globalSearch,
            'created_at' => $this->globalSearch,
            'updated_at' => $this->globalSearch,
        ]);

        $query->orFilterWhere(['like', 'name', $this->globalSearch])
            ->orFilterWhere(['like', 'address', $this->globalSearch])
            ->orFilterWhere(['like', 'type', $this->globalSearch])
            ->orFilterWhere(['like', 'description', $this->globalSearch]);

    } else {
        $query->andFilterWhere([
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'status_id' => $this->status_id,
            'is_deleted' => $this->is_deleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'description', $this->description]);
    }

    return $dataProvider;
}

}
