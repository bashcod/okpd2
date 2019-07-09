<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Okpd2;

/**
 * Okpd2Search represents the model behind the search form of `app\models\Okpd2`.
 */
class Okpd2Search extends Okpd2
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'global_id'], 'integer'],
            [['name', 'razdel', 'idx', 'kod', 'nomdescr'], 'safe'],
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
        $query = Okpd2::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'global_id' => $this->global_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'razdel', $this->razdel])
            ->andFilterWhere(['ilike', 'idx', $this->idx])
            ->andFilterWhere(['ilike', 'kod', $this->kod])
            ->andFilterWhere(['ilike', 'nomdescr', $this->nomdescr]);

        return $dataProvider;
    }
}
