<?php

namespace common\models\patente;

use Yii;

/**
 * This is the model class for table "esa_rispquiz".
 *
 * @property int $IdDomanda
 * @property int $IdDomandaTest
 * @property int $IdRispTest
 * @property int $RespVero
 * @property int $RespFalso
 * @property int $bControllata
 * @property int $EsitoRisp
 * @property string $ultagg
 * @property string $utente
 *
 * @property EsaDomanda $idDomanda
 */
class RispQuiz extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esa_rispquiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdDomanda', 'IdDomandaTest', 'RespVero', 'RespFalso', 'bControllata', 'EsitoRisp'], 'integer'],
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
            'IdDomanda' => 'Id Domanda',
            'IdDomandaTest' => 'Id Domanda Test',
            'IdRispTest' => 'Id Risp Test',
            'RespVero' => 'Resp Vero',
            'RespFalso' => 'Resp Falso',
            'bControllata' => 'B Controllata',
            'EsitoRisp' => 'Esito Risp',
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
