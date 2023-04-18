<?php

namespace common\models\patente;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "esa_quiz".
 *
 * @property int $CdUtente
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
            [['CdUtente'], 'integer'],
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
            'CdUtente' => 'Cd Utente',
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
