<?php
namespace common\models\busy;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\busy\Obiettivo;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for searching Obiettivo.
 */

class ObiettivoSearch extends Obiettivo
{
	
	public static function tableName()
    {
        return 'obiettivo';
    }
	
    public function rules()
    {
        return [
			[['IdSoggetto','TpOccup','IdObiettivo','MinPrevisti'], 'integer'],
			[['DescObiettivo'],'string','max' => 1000],
			[['NotaObiettivo'],'string','max' => 2000],
			[['DtInizioObiettivo','DtScadenzaObiettivo','DtFineObiettivo'], 'safe'],
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
            'pagination' => [
                'pageSize' => 30,
            ]   
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ( !empty($this->DtInizioRicerca)) {
            $query->andWhere(['>=','DtCreazioneTest',$this->DtInizioRicerca]);
        }
        if ( !empty($this->DtFineRicerca)) {
            $query->andWhere(['<=','DtCreazioneTest',$this->DtFineRicerca]);
        }
        if ( !empty($this->IdSoggetto)) {
            $query->andFilterWhere([
                'IdSoggetto'=>$this->IdSoggetto,
             ]);
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'IdObiettivo'=>$this->IdObiettivo
        ]);
        //$dataProvider->sort->defaultOrder = ['IdQuiz' => SORT_DESC];

        /*$query->andFilterWhere(['like', 'DescObiettivo', $this->DescObiettivo])
            ->andFilterWhere(['like', 'NotaObiettivo', $this->NotaObiettivo])
            ->andFilterWhere(['like', 'utente', $this->utente]);
            */
        return $dataProvider;
    }	


    /**
     * Gets query for [[Lavoro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchLavoro($params, $id)
    {
		$query = Obiettivo::find()->with('lavoro')->where('IdObiettivo=' . $id); // domandaquiz.domanda
		// add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ]            
        ]);
        return $dataProvider;
        //$this->load($params);

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
         //   return $dataProvider;
        //}

        // grid filtering conditions
        /*$query->andFilterWhere([
            'IdQuiz' => $id, //$params->expandRowKey, //$this->expandRowInd, //IdQuiz,
        ]);	*/	
    }    

    /**
     * Gets query for [[DocObiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchDocobiettivo($params, $id)
    {
		$query = Obiettivo::find()->with('docobiettivo')->where('IdObiettivo=' . $id); // domandaquiz.domanda
		// add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ]            
        ]);
        return $dataProvider;
        //$this->load($params);

        //if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
         //   return $dataProvider;
        //}

        // grid filtering conditions
        /*$query->andFilterWhere([
            'IdQuiz' => $id, //$params->expandRowKey, //$this->expandRowInd, //IdQuiz,
        ]);	*/	
    }    

    /**
     * Gets query for [[Soggetto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSoggetto()
    {
        return $this->hasOne(\common\models\busy\Soggetto::class,  ['IdSoggetto' => 'IdSoggetto',]);
    }    

    /**
     * Gets query for [[TipoOccupazione]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipooccupazione()
    {
        return $this->hasOne(\common\models\busy\TipoOccupazione::class,  ['TpOccup' => 'TpOccup',]);
    }    


}

