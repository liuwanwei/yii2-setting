<?php

namespace buddysoft\setting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use buddysoft\setting\SettingHelper;

/**
 * SettingSearch represents the model behind the search form about `backend\setting\models\ChangeLog`.
 */
class ChangeLogSearch extends ChangeLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['key'], 'safe'],
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
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['userId' => $this->userId]);
        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
