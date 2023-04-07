<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Docobiettivo;

/**
 * DocobiettivoSearch represents the model behind the search form of `common\models\Docobiettivo`.
 */
class DocobiettivoSearch extends Docobiettivo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdObiettivo', 'IdDocObiettivo'], 'integer'],
            [['DtDoc', 'PathDoc', 'NotaDoc', 'ultagg', 'utente'], 'safe'],
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
        $query = Docobiettivo::find();

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
            'IdDocObiettivo' => $this->IdDocObiettivo,
            'DtDoc' => $this->DtDoc,
            'ultagg' => $this->ultagg,
        ]);

        $query->andFilterWhere(['like', 'PathDoc', $this->PathDoc])
            ->andFilterWhere(['like', 'NotaDoc', $this->NotaDoc])
            ->andFilterWhere(['like', 'utente', $this->utente]);

        return $dataProvider;
    }
}
