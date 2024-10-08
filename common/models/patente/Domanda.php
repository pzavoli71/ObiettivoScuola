<?php

namespace common\models\patente;

use Yii;

/**
 * This is the model class for table "esa_domanda".
 *
 * @property int $IdDomanda
 * @property int $IdCapitolo
 * @property int $IdDom
 * @property int $IdProgr
 * @property string $Asserzione
 * @property int $Valore
 * @property string $linkimg
 * @property string $ultagg
 * @property string $utente
 *
 * @property EsaDomandaquiz[] $esaDomandaquizzes
 * @property EsaRispquiz[] $esaRispquizzes
 */
class Domanda extends \common\models\BaseModel
{
    public $bool_columns = ['bPatenteAB'];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'esa_domanda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdCapitolo', 'IdDom', 'IdProgr', 'Valore', 'bPatenteAB','Oscura'], 'integer'],
            [['ultagg'], 'safe'],
            [['Asserzione'], 'string', 'max' => 200],
            [['linkimg'], 'string', 'max' => 100],
            [['utente'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdDomanda' => 'Id Domanda',
            'IdCapitolo' => 'Id Capitolo',
            'IdDom' => 'Id Dom',
            'IdProgr' => 'Id Progr',
            'Asserzione' => 'Asserzione',
            'Valore' => 'Valore',
            'linkimg' => 'Linkimg',
            'Oscura' => 'Oscura domanda',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[EsaDomandaquizzes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDomandaquiz()
    {
        return $this->hasMany(DomandaQuiz::class, ['IdDomanda' => 'IdDomanda']);
    }

    /**
     * Gets query for [[EsaRispquizzes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRispquiz()
    {
        return $this->hasMany(RispQuiz::class, ['IdDomanda' => 'IdDomanda']);
    }
}
