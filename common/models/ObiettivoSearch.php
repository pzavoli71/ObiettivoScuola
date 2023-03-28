<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Obiettivo;

/**
 * ObiettivoSearch represents the model behind the search form of `common\models\Obiettivo`.
 */
class ObiettivoSearch extends Obiettivo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdObiettivo', 'IdSoggetto', 'TpOccup', 'MinPrevisti'], 'integer'],
            [['DtInizioObiettivo', 'DescObiettivo', 'DtScadenzaObiettivo', 'DtFineObiettivo', 'NotaObiettivo', 'ultagg', 'utente'], 'safe'],
            [['PercCompletamento'], 'number'],
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
        $query = Obiettivo::find();

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
            'IdObiettivo' => $this->IdObiettivo,
            'IdSoggetto' => $this->IdSoggetto,
            'TpOccup' => $this->TpOccup,
            'DtInizioObiettivo' => $this->DtInizioObiettivo,
            'DtScadenzaObiettivo' => $this->DtScadenzaObiettivo,
            'MinPrevisti' => $this->MinPrevisti,
            'DtFineObiettivo' => $this->DtFineObiettivo,
            'PercCompletamento' => $this->PercCompletamento,
            'ultagg' => $this->ultagg,
        ]);

        $query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);

        return $dataProvider;
    }
}
