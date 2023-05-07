<?php
namespace common\models\busy;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\busy\TipoOccupazione;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for searching TipoOccupazione.
 */

class TipoOccupazioneSearch extends TipoOccupazione
{
	
	public static function tableName()
    {
        return 'tipooccupazione';
    }
	
    public function rules()
    {
        return [
			[['TpOccup'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['DsOccup'],'string','max' => 200],
			//[[], 'safe'],
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
            'TpOccup'=>$this->TpOccup
        ]);

        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
            */
        return $dataProvider;
    }	


    /**
     * Gets query for [[Obiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchObiettivo($params, $id)
    {
		$query = TipoOccupazione::find()->with('obiettivo')->where('=' . $id); // domandaquiz.domanda
		// add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ]            
        ]);
        //$this->load($params);

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
         //   return $dataProvider;
        //}

        // grid filtering conditions
        /*$query->andFilterWhere([
            'IdQuiz' => $id, //$params->expandRowKey, //$this->expandRowInd, //IdQuiz,
        ]);*/		
    }    


}

