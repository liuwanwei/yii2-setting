<?php

namespace buddysoft\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use buddysoft\setting\SettingHelper;

/**
 * SettingSearch represents the model behind the search form about `backend\modules\setting\models\Setting`.
 */
class SettingSearch extends Setting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoryId'], 'integer'],
            [['key', 'value', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Setting::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'weight' => SORT_ASC,
                ]
            ]
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'categoryId' => $this->categoryId,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'description', $this->description]);

        // 如果定义了字段前缀，只搜索前缀开始的字段
        $prefix = SettingHelper::keyPrefix();
        if (! empty($prefix)) {
            $query->andFilterWhere(['like', 'key', $prefix]);
        }

        return $dataProvider;
    }
}
