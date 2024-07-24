<?php

namespace common\models\patente;

use Yii;

/**
 * This is the model class for table "esa_domandaquiz".
 *
 * @property int $IdQuiz
 * @property int $IdDomanda
 * @property int $IdDomandaTest
 * @property string $ultagg
 * @property string $utente
 *
 * @property EsaDomanda $idDomanda
 */
class DomandaQuiz extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esa_domandaquiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdQuiz','IdDomanda','IdDomandaTest'], 'integer'],
            [['ultagg'], 'safe'],
            [['utente'], 'string', 'max' => 20],
            //[['IdDomanda'], 'exist', 'skipOnError' => true, 'targetClass' => Domanda::class, 'targetAttribute' => ['IdDomanda' => 'IdDomanda']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdQuiz' => 'Id Quiz',
            'IdDomanda' => 'Id Domanda',
            'IdDomandaTest' => 'Id Domanda Test',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[RispQuiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRispquiz()
    {
        return $this->hasMany(\common\models\patente\RispQuiz::class,  ['IdDomandaTest' => 'IdDomandaTest']);
    }    

    /**
     * Gets query for [[Quiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuiz()
    {
        return $this->hasOne(\common\models\patente\Quiz::class,  ['IdQuiz' => 'IdQuiz']);
    }    

    /**
     * Gets query for [[Domanda]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomanda()
    {
        return $this->hasOne(Domanda::class, ['IdDomanda' => 'IdDomanda']);
        
        /*$quiz = $this->getQuiz()->one();
        if ( $quiz->bPatenteAB) {
            return $this->hasOne(DomandaAB::class, ['IdDomanda' => 'IdDomanda']);            
        } else {
            return $this->hasOne(Domanda::class, ['IdDomanda' => 'IdDomanda']);
        }*/
        //return $this->find()->joinWith('quiz')->where('esa_quiz.IdCompPartita = ' . $this->request->queryParams['IdCompPartita'])->all()
        //return $this->hasOne(Domanda::class, ['IdDomanda' => 'IdDomanda']);
    }
}
