<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "Lavoro".
 *

 * @property int	$IdObiettivo,

 * @property int	$IdLavoro,

 * @property string|DateTime|null	$DtLavoro,

 * @property int	$OraInizio,

 * @property int	$MinutiInizio,

 * @property string|null	$NotaLavoro,

 * @property int	$OraFine,

 * @property int	$MinutiFine,

 */

class Lavoro extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['IdObiettivo','IdLavoro','OraInizio','MinutiInizio','OraFine','MinutiFine'];
	public $datetime_columns = ['DtLavoro'];
	
	public static function tableName()
    {
        return 'Lavoro';
    }
	
    public function rules()
    {
        return [
			[['IdObiettivo','IdLavoro','OraInizio','MinutiInizio','OraFine','MinutiFine'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['NotaLavoro'],'string','max' => 1000],
			[['DtLavoro'], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'IdObiettivo' => 'Id Obiettivo',
	
			'IdLavoro' => 'Id Lavoro',
	
			'DtLavoro' => 'Dt Lavoro',
	
			'OraInizio' => 'Ora Inizio',
	
			'MinutiInizio' => 'Minuti Inizio',
	
			'NotaLavoro' => 'Nota Lavoro',
	
			'OraFine' => 'Ora Fine',
	
			'MinutiFine' => 'Minuti Fine',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[Obiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObiettivo()
    {
        return $this->hasOne(\common\models\busy\Obiettivo::class,  ['IdObiettivo' => 'IdObiettivo']);
    }    


}

