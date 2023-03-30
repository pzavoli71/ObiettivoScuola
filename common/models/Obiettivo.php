<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "obiettivo".
 *
 * @property int $IdObiettivo
 * @property int $IdSoggetto
 * @property int $TpOccup
 * @property string|null $DtInizioObiettivo
 * @property string $DescObiettivo
 * @property string|null $DtScadenzaObiettivo
 * @property int $MinPrevisti
 * @property string|null $DtFineObiettivo
 * @property string $NotaObiettivo
 * @property float $PercCompletamento
 * @property string $ultagg
 * @property string $utente
 *
 * @property Docobiettivo[] $docobiettivos
 * @property Soggetto $idSoggetto
 * @property Lavoro[] $lavoros
 * @property Tipooccupazione $tpOccup
 */
class Obiettivo extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obiettivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdObiettivo', 'IdSoggetto', 'TpOccup', 'MinPrevisti'], 'integer'],
            //[['DtInizioObiettivo', 'DtScadenzaObiettivo', 'DtFineObiettivo'], 'date'],
            [['DtInizioObiettivo', 'DtScadenzaObiettivo', 'DtFineObiettivo', 'ultagg'], 'safe'],
            [['DtInizioObiettivo', 'DtScadenzaObiettivo', 'DtFineObiettivo'],'default', 'value' => null],
            [['PercCompletamento'], 'number'],
            [['DescObiettivo'], 'string', 'max' => 1000],
            [['NotaObiettivo'], 'string', 'max' => 2000],
            [['utente'], 'string', 'max' => 20],
            [['IdObiettivo'], 'unique'],
            [['IdSoggetto'], 'exist', 'skipOnError' => true, 'targetClass' => Soggetto::class, 'targetAttribute' => ['IdSoggetto' => 'IdSoggetto']],
            [['TpOccup'], 'exist', 'skipOnError' => true, 'targetClass' => Tipooccupazione::class, 'targetAttribute' => ['TpOccup' => 'TpOccup']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdObiettivo' => 'Id Obiettivo',
            'IdSoggetto' => 'Id Soggetto',
            'TpOccup' => 'Tp Occup',
            'DtInizioObiettivo' => 'Dt Inizio Obiettivo',
            'DescObiettivo' => 'Desc Obiettivo',
            'DtScadenzaObiettivo' => 'Dt Scadenza Obiettivo',
            'MinPrevisti' => 'Min Previsti',
            'DtFineObiettivo' => 'Dt Fine Obiettivo',
            'NotaObiettivo' => 'Nota Obiettivo',
            'PercCompletamento' => 'Perc Completamento',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[Docobiettivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocobiettivos()
    {
        return $this->hasMany(Docobiettivo::class, ['IdObiettivo' => 'IdObiettivo']);
    }

    /**
     * Gets query for [[IdSoggetto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdSoggetto()
    {
        return $this->hasOne(Soggetto::class, ['IdSoggetto' => 'IdSoggetto']);
    }

    /**
     * Gets query for [[Lavoros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLavoros()
    {
        return $this->hasMany(Lavoro::class, ['IdObiettivo' => 'IdObiettivo']);
    }

    /**
     * Gets query for [[TpOccup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTpOccup()
    {
        return $this->hasOne(Tipooccupazione::class, ['TpOccup' => 'TpOccup']);
    }
    
    public function beforeValidate()
    {
        if ( !parent::beforeValidate())
            return false;
        $dt = $this->DtInizioObiettivo;
        if ( $dt === null)
            return true;
        $parsed = \DateTime::createFromFormat('d/m/Y', $dt);        
        if ( $parsed)
            return true;
        $parsed = \DateTime::createFromFormat('dmY', $dt);        
        if ( !$parsed) {
            $this->addError('DtInizioObiettivo', 'il campo DtInizio non è valido');     
            return false;
        }
        return true;
    }
    
    public function beforeSave($insert) {
        if ( !parent::beforeSave($insert))
            return false;
        $dt = $this->DtInizioObiettivo;
        if ( $dt === null)
            return true;
        $parsed = \DateTime::createFromFormat('dd/MM/yyyy', $dt);        
        if ( $parsed)
            return true;
        $parsed = \DateTime::createFromFormat('dmY', $dt);        
        if ( !$parsed) {
            return false;
        }
        $formatted = \Yii::$app->formatter->asDate($parsed, 'php:d/m/Y');
        $this->DtInizioObiettivo = $formatted;
        return true;
    }
    
}
