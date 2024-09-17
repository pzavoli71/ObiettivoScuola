<?php
namespace common\models\patente;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\patente\Quiz;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for searching Quiz.
 */

class QuizSearch extends Quiz
{
	
	public static function tableName()
    {
        return 'esa_quiz';
    }
	
    public function rules()
    {
        return [
			[['id','IdQuiz','EsitoTest'], 'integer'],
			[['bRispSbagliate','bPatenteAB'], 'boolean','trueValue'=>'-1'],
			[['DtCreazioneTest','DtInizioTest','DtFineTest'], 'safe'],
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
            'IdQuiz'=>$this->IdQuiz
        ]);
        if ( !empty($params['QuizSearch']['id'])) {
            $query->andFilterWhere([
                'id'=>$params['QuizSearch']['id']
            ]);            
        }
        $query->addOrderBy('DtCreazioneTest desc');

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
        $query = Quiz::find()->with('domandaquiz')->where('IdQuiz=' . $id); // domandaquiz.domanda
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],            
        ]);
        $this->load($params);
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

    public function searchDomandaquizSbagliate($params, $id)
    {
        $query = Quiz::find()->with('domandaquiz')->where('IdQuiz=' . $id); // domandaquiz.domanda
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ]
        ]);
        $this->load($params);
        return $dataProvider;
    }    

    public function searchDomandaquizSbagliateUser($params, $id, $userid)
    {
        $subQuery = (new \yii\db\Query)
                ->select([new \yii\db\Expression('1')])
                ->from('esa_rispquiz q2, esa_domandaquiz')
                ->where('esa_domandaquiz.IdQuiz = esa_quiz.IdQuiz AND esa_domandaquiz.idDomandaTest = q2.idDomandaTest AND q2.bControllata = -1 AND EsitoRisp != 0');        
        $query = Quiz::find()->with('domandaquiz')->where('esa_quiz.id=' . $userid . ' AND DtFineTest IS NOT NULL')
                ->andWhere(["exists", $subQuery]); // domandaquiz.domanda
        $q = $query->createCommand()->getRawSql();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10000,
            ]
        ]);
        $this->load($params);
        return $dataProvider;
    }                        

    /**
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchTest($params, $id)
    {
		$query = Quiz::find()->with('test')->where('IdQuiz=' . $id); // domandaquiz.domanda
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
     * Gets query for [[Test]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function searchRispQuiz($params, $id)
    {
		$query = DomandaQuiz::find()->with('rispquiz')->where('IdDomandaTest=' . $params['IdDomandaTest']); // domandaquiz.domanda
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
     * Gets query for [[user]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\patente\user::class,  ['id' => 'id']);
    }    


}

