<?php

namespace common\models\patente;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "esa_quiz".
 *
 * @property int $id
 * @property int $IdQuiz
 * @property string|null $DtCreazioneTest
 * @property string|null $DtInizioTest
 * @property int $EsitoTest
 * @property string|null $DtFineTest
 * @property int $bRispSbagliate
 * @property string $ultagg
 * @property string $utente
 */
class Quiz extends \common\models\BaseModel
{
    public $bool_columns = ['bRispSbagliate'];
    public $number_columns = ['EsitoTest'];
    public $datetime_columns = ['DtCreazioneTest'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esa_quiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['DtCreazioneTest', 'DtInizioTest', 'DtFineTest', 'ultagg'], 'safe'],
            [['utente'], 'string', 'max' => 20],
            ['bRispSbagliate', 'required'],
            ['bRispSbagliate', 'boolean','trueValue'=>'-1'],
            //['EsitoTest','number'],
            ['EsitoTest','match','pattern'=>'/^[+-]?[0-9\.,]+$/','message' => 'Immettere un numero valido']
            //['bRispSbagliate','match','pattern'=>'/^[+-]?[0-9\.]+$/','message' => 'Immettere un numero valido']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id Utente',
            'IdQuiz' => 'Id Quiz',
            'DtCreazioneTest' => 'Dt Creazione Test',
            'DtInizioTest' => 'Dt Inizio Test',
            'EsitoTest' => 'Esito Test',
            'DtFineTest' => 'Dt Fine Test',
            'bRispSbagliate' => 'B Risp Sbagliate',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }
    /**
     * Gets query for [[DomandaQuiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomandaquiz()
    {
        return $this->hasMany(DomandaQuiz::class, ['IdQuiz' => 'IdQuiz']);
    }    
    public function getTest()
    {
        return $this->hasMany(Test::class, ['IdQuiz' => 'IdQuiz']);
    }    
    public function getUser()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'id']);
    }    
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ( !$insert) 
            return true;
        $sql = "select d.IdCapitolo, d.IdDomanda, d.Asserzione, (
            select count(*) from ESA_DomandaQuiz dq where dq.IdDomanda = d.IdDomanda
            ) as conteggiodomandefatte,
            IfNull(t.RisposteSbagliate,0) as rispostesbagliate
            from ESA_Domanda d left outer join
            (
            select dd.IdDomanda, count(rq.IdDomandaTest) as RisposteSbagliate
            from esa_rispquiz rq inner join ESA_Domanda d1 on d1.IdDomanda = rq.IdDomanda
            inner join ESA_Domanda dd on dd.IdCapitolo = d1.IdCapitolo and dd.IdDom = d1.IdDom and dd.IdProgr = 0
            inner join ESA_DomandaQuiz dq on dq.IdDomandaTest = rq.IdDomandaTest
            where rq.EsitoRisp = -1 and rq.bControllata = -1
            and
            ((d1.valore != 0 and RespVero = 0) or (d1.valore = 0 and RespFalso = 0))
            group by dd.IdDomanda
            ) as t
            on t.IdDomanda = d.IdDomanda
            where d.idprogr = 0
            ORDER BY D.iDcAPITOLO, D.iDdOMANDA";
        //$query = Query()::findBySql($sql);
        $oldidcap = 0; $somma = 0.0; $numdomande = 0;
        $capitoli = []; $htdomande = [];
        $query = \Yii::$app->getDb()->createCommand($sql)->queryAll();
        foreach ($query as $riga) {
            $idcapitolo = $riga['IdCapitolo'];
            //if ( !key_exists($idcapitolo, $capitoli)) {
                if ($oldidcap > 0 && $oldidcap != $idcapitolo) {
                    //$htdomande = $capitoli[$oldidcap];
                    $keys = array_keys($htdomande);
                    for ($i = 0; $i < sizeof($keys); $i++) {
                        $iddom = $keys[$i];
                        $bd = $htdomande[$iddom];
                        $bd = $bd / $somma;
                        $htdomande[$iddom] = $bd;
                    }
                    $capitoli[$oldidcap] = $htdomande;                    
                    $htdomande = [];
                    $somma = 0; $numdomande = 0;
                }
                //$capitoli[$idcapitolo] = &$htdomande;
            /*} else {
                $htdomande = $capitoli[$idcapitolo];
            } */      
            $bdvalore = 0.0;
            $iddomanda = $riga['IdDomanda'];
            $conteggiodomandefatte = $riga['conteggiodomandefatte'];
            $rispsbagliate = $riga['rispostesbagliate'];
            if ( $conteggiodomandefatte == 0) {
                $bdvalore = 1000.0;
            } else {
                $bdvalore = $rispsbagliate;
            }
            $htdomande[$iddomanda] = $bdvalore;
            $somma = $somma + $bdvalore;
            $numdomande++;
            $oldidcap = $idcapitolo;
        }
        if ( $oldidcap > 0 ) {
            //$htdomande = $capitoli[$oldidcap];
            $keys = array_keys($htdomande);
            for ($i = 0; $i < sizeof($keys); $i++) {
                $iddom = $keys[$i];
                $bd = $htdomande[$iddom];
                $bd = $bd / $somma;
                $htdomande[$iddom] = $bd;
            }            
            $capitoli[$oldidcap] = $htdomande;                    
        }
        
        $sql = "select distinct IdCapitolo from esa_domanda order by 1";
        $query = \Yii::$app->getDb()->createCommand($sql)->queryAll();
        if ( sizeof($query) == 0) 
            throw new \yii\base\UserException("Non trovo i capitoli delle domande");
        foreach ($query as $riga) {
            $idcapitolo = $riga['IdCapitolo'];
            $sql = "select IdDomanda, IdDom from esa_domanda where idprogr = 0 and idcapitolo = " . $idcapitolo . " order by 2";
            $query2 = \Yii::$app->getDb()->createCommand($sql)->queryAll();
            if ( sizeof($query2) == 0) 
                throw new \yii\base\UserException("Non le domande del capitolo " . $idcapitolo);
            $elemrandomtrovato = [];
            $elemrandomtrovato[0] = -1;
            $rnd0 = -1.0;
            $iddomanda = 0; $iddom = 0;
            foreach ($query2 as $rigadomanda) {
                $rnd2 = mt_rand(0,500);
                if (sizeof($capitoli) > 0) {
                    $htdomande = $capitoli[$idcapitolo];
                    $bd = $htdomande[$rigadomanda['IdDomanda']];
                    $rnd2 = $bd;
                }
                if ($rnd2 > $rnd0 ) {
                    $iddomanda = $rigadomanda['IdDomanda'];
                    $iddom = $rigadomanda['IdDom'];
                    $rnd0 = $rnd2;
                }
            }
            
            // Scrivo la domanda appena trovata su db
            $domanda = new DomandaQuiz();
            $domanda->IdQuiz = $this->IdQuiz;
            $domanda->IdDomanda = $iddomanda;
            if ( !$domanda->save())
                throw new \yii\base\UserException("Non riesco ad inserire la domanda n. " . $IdDomanda);
            
            // Ora inserisco tre possibili risposte
            $elemrandomtrovato[0] = -1;$elemrandomtrovato[1] = -1;$elemrandomtrovato[2] = -1;
            $rnd1 = -1.0; $rnd2 = -2.0; $rnd3 = -3.0;
            $sql = "select IdDomanda, IdProgr from esa_domanda where idprogr > 0 and idcapitolo = " . $idcapitolo . " and iddom = " . $iddom . " order by 2";
            $query2 = \Yii::$app->getDb()->createCommand($sql)->queryAll();
            if ( sizeof($query2) == 0) 
                throw new \yii\base\UserException("Non trovo le risposte della domanda " . $iddom);
            $v = [];
            $i = 0;
            foreach ($query2 as $rigadomande) {
                $rnd4 = mt_rand(0,500);
                $v[$i] = $rnd4;                
                $i++;
            }
            $rnd0 = -1;
            for ($i = 0; $i < sizeof($query2); $i++) {
                if ( $v[$i] > $rnd0) {
                    $elemrandomtrovato[0] = $i;
                    $rnd0 = $v[$i];
                }
            }
            $v[$elemrandomtrovato[0]] = -1.0; $rnd0 = -1.0;
            for ($i = 0; $i < sizeof($query2); $i++) {
                if ( $v[$i] > $rnd0) {
                    $elemrandomtrovato[1] = $i;
                    $rnd0 = $v[$i];
                }
            }
            $v[$elemrandomtrovato[1]] = -1.0; $rnd0 = -1.0;
            for ($i = 0; $i < sizeof($query2); $i++) {
                if ( $v[$i] > $rnd0) {
                    $elemrandomtrovato[2] = $i;
                    $rnd0 = $v[$i];
                }
            }
            for ( $i = 0; $i < 3; $i++) {
                $rigatrovata = $query2[$elemrandomtrovato[$i]];
                $iddomanda = $rigatrovata['IdDomanda'];
                $risp = new RispQuiz();
                $risp->IdDomanda = $iddomanda;
                $risp->IdDomandaTest = $domanda->IdDomandaTest;
                if ( !$risp->save())
                    throw new \yii\base\UserException("Non riesco ad inserire la risposta n. " . $domanda->IdDomandaTest . " alla domanda " . $iddomanda);                
            }
        }
        return true;
    }
    
    /*
    public function behaviors()
    {
        $rules = parent::behaviors();
        return array_merge($rules, [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['bRispSbagliate'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['bRispSbagliate'], // update 1 attribute 'created' OR multiple attribute ['created','updated']
                ],
                'value' => function ($event) {
                    $conv = str_replace('.', '', $this->bRispSbagliate);
                    return $conv;
                    //return date('Y-m-d H:i:s', strtotime($this->LastUpdated));
                },
            ],
        ]);
    }    
    */
}
