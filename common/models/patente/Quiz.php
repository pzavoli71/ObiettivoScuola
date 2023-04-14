<?php

namespace common\models\patente;

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
            [['CdUtente', 'EsitoTest', 'bRispSbagliate'], 'integer'],
            [['DtCreazioneTest', 'DtInizioTest', 'DtFineTest', 'ultagg'], 'safe'],
            [['utente'], 'string', 'max' => 20],
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

    
}
