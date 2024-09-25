<?php
namespace common\models\patente;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\patente\Domanda;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for searching Domanda.
 */

class DomandaSearch extends Domanda
{
	
	public static function tableName()
    {
        return 'esa_domanda';
    }
	
    public function rules()
    {
        return [
			[['IdDomanda','IdCapitolo','IdDom','IdProgr'], 'integer'],
			[['Valore','bPatenteAB'], 'boolean','trueValue'=>'-1'],
			[['Asserzione'],'string','max' => 200],
			[['linkimg'],'string','max' => 100],
			[[], 'safe'],
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
        $query = Domanda::find();

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
            'IdDom'=>$this->IdDom
        ]);
        $query->andFilterWhere([
            'IdCapitolo'=>$this->IdCapitolo
        ]);
        $query->andFilterWhere([
            'IdDomanda'=>$this->IdDomanda
        ]);
        $query->andFilterWhere([
            'IdProgr'=>0
        ]);
        $query->andFilterWhere([
            'Oscura'=>0
        ]);
        if ( !empty($this->Asserzione)) {
            $query->andFilterWhere([
                'like','Asserzione',$this->Asserzione
            ]);
        }

        $query->andFilterWhere(['=', 'bPatenteAB', -1]);
        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
            */
        return $dataProvider;
    }	


    /**
     * Gets query for [[DomandaQuiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchDomandaquiz($params, $id)
    {
        $query = Domanda::find()->with('domandaquiz')->where('IdDomanda=' . $id); // domandaquiz.domanda
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ]            
        ]);
        $this->load($params);

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
         //   return $dataProvider;
        //}

        /*if ( !empty($this->DtFineRicerca)) {
            $query->andWhere(['<=','DtCreazioneTest',$this->DtFineRicerca]);
        }*/

        // grid filtering conditions
        /*$query->andFilterWhere([
            'IdQuiz' => $id, //$params->expandRowKey, //$this->expandRowInd, //IdQuiz,
        ]);	*/	
        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
		*/
		return $dataProvider;
    }    

    /**
     * Gets query for [[RispQuiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchRispquiz($params, $id)
    {
        $domanda = Domanda::findOne(['IdDomanda' => $id]);
        $query = Domanda::find()->where('IdDom=' . strval($domanda->IdDom) . ' AND IdCapitolo = ' . strval($domanda->IdCapitolo) . ' AND IdProgr > 0 AND Oscura = 0'); // domandaquiz.domanda
        // add conditions that should always apply here 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ]            
        ]);
        $this->load($params);

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
         //   return $dataProvider;
        //}

        /*if ( !empty($this->DtFineRicerca)) {
            $query->andWhere(['<=','DtCreazioneTest',$this->DtFineRicerca]);
        }*/

        // grid filtering conditions
        /*$query->andFilterWhere([
            'IdQuiz' => $id, //$params->expandRowKey, //$this->expandRowInd, //IdQuiz,
        ]);	*/	
        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
		*/
		return $dataProvider;
    }    


}

