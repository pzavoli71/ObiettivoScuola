<?php
namespace common\models\busy;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\busy\Argomento;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for searching Argomento.
 */

class ArgomentoSearch extends Argomento
{
	
	public static function tableName()
    {
        return 'DO_Argomento';
    }
	
    public function rules()
    {
        return [
			[['IdArg','IdArgPadre'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['DsArgomento'],'string','max' => 300],
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
        $query = Argomento::find();

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
            'IdArg'=>$this->IdArg
        ]);

        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
            */
        return $dataProvider;
    }	


    /**
     * Gets query for [[TipoOccupazione]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchTipooccupazione($params, $id)
    {
		$query = Argomento::find()->with('tipooccupazione')->where('IdArg=' . $id); // domandaquiz.domanda
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
     * Gets query for [[Obiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchObiettivo($params, $id)
    {
		$query = Argomento::find()->with('obiettivo')->where('IdArg=' . $id); // domandaquiz.domanda
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
     * Gets query for [[PermessoArg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchPermessoarg($params, $id)
    {
		$query = Argomento::find()->with('permessoarg')->where('IdArg=' . $id); // domandaquiz.domanda
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


}

