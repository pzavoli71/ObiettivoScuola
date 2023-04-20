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
            [['IdQuiz', 'IdDomanda'], 'integer'],
            [['ultagg'], 'safe'],
            [['utente'], 'string', 'max' => 20],
            [['IdDomanda'], 'exist', 'skipOnError' => true, 'targetClass' => Domanda::class, 'targetAttribute' => ['IdDomanda' => 'IdDomanda']],
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
     * Gets query for [[IdDomanda]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomanda()
    {
        return $this->hasOne(Domanda::class, ['IdDomanda' => 'IdDomanda']);
    }
}
