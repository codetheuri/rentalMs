<?php

namespace dashboard\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use dashboard\models\Unit;
use Yii;

/**
 * UnitSearch represents the model behind the search form of `dashboard\models\Unit`.
 */
class UnitSearch extends Unit
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'property_id', 'status_id', 'is_deleted', 'created_at', 'updated_at'], 'integer'],
            [['unit_number'], 'safe'],
            [['monthly_rent'], 'number'],
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
        $query = Unit::find()->alias('u')->where(['u.is_deleted' => 0]);

        // 🧠 Only show units of properties owned by this user
        // if (Yii::$app->user->can('dashboard-property-create')) {
        //     $query->joinWith('property p')->andWhere(['p.owner_id' => Yii::$app->user->id]);
        // } elseif (\Yii::$app->user->can('dashboard-property-delete')) {
        //     $query = Unit::find();
        // }

        $query = Unit::find();

        // existing dataProvider logic
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        // load filters
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // Apply additional filters here (unit_number, rent, etc)
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.monthly_rent' => $this->monthly_rent,
            'u.status_id' => $this->status_id,
            'u.property_id' => $this->property_id,
        ]);

        $query->andFilterWhere(['like', 'u.unit_number', $this->unit_number]);

        return $dataProvider;
    }
}
