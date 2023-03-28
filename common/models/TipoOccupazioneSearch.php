<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TipoOccupazione;

/**
 * TipoOccupazioneSearch represents the model behind the search form of `app\models\TipoOccupazione`.
 */
class TipoOccupazioneSearch extends TipoOccupazione
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TpOccup'], 'integer'],
            [['DsOccup', 'ultagg', 'utente'], 'safe'],
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
        $query = TipoOccupazione::find();

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
            'TpOccup' => $this->TpOccup,
            'ultagg' => $this->ultagg,
        ]);

        $query->andFilterWhere(['like', 'DsOccup', $this->DsOccup])
            ->andFilterWhere(['like', 'utente', $this->utente]);

        return $dataProvider;
    }
}
