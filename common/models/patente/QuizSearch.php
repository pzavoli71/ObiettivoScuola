<?php

namespace common\models\patente;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\patente\Quiz;

/**
 * ObiettivoSearch represents the model behind the search form of `common\models\Obiettivo`.
 */
class QuizSearch extends Quiz
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdQuiz', 'EsitoTest', 'bRispSbagliate'], 'integer'],
            [['DtCreazioneTest', 'DtInizioTest', 'DtFineTest', 'DtFineObiettivo', 'ultagg', 'utente'], 'safe'],
            
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
        $query = Quiz::find();

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
            'IdQuiz' => $this->IdQuiz
        ]);

        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
            */
        return $dataProvider;
    }
}
