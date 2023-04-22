<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "Obiettivo".
 *

 * @property int	$IdSoggetto,

 * @property int	$TpOccup,

 * @property int	$IdObiettivo,

 * @property string|DateTime|null	$DtInizioObiettivo,

 * @property string|null	$DescObiettivo,

 * @property string|DateTime|null	$DtScadenzaObiettivo,

 * @property int	$MinPrevisti,

 * @property string|DateTime|null	$DtFineObiettivo,

 * @property string|null	$NotaObiettivo,

 * @property float	$PercCompletamento,

 */

class Obiettivo extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['IdSoggetto','TpOccup','IdObiettivo','MinPrevisti'];
	public $datetime_columns = ['DtInizioObiettivo','DtScadenzaObiettivo','DtFineObiettivo'];
	
	public static function tableName()
    {
        return 'Obiettivo';
    }
	
    public function rules()
    {
        return [
			[['IdSoggetto','TpOccup','IdObiettivo','MinPrevisti'], 'integer'],
			//[[], 'boolean','trueValue'=>'-1'],
			[['DescObiettivo'],'string','max' => 1000],
			[['NotaObiettivo'],'string','max' => 2000],
			[['DtInizioObiettivo','DtScadenzaObiettivo','DtFineObiettivo'], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'IdSoggetto' => 'Id Soggetto',
	
			'TpOccup' => 'Tp Occup',
	
			'IdObiettivo' => 'Id Obiettivo',
	
			'DtInizioObiettivo' => 'Dt InizioObiettivo',
	
			'DescObiettivo' => 'Desc Obiettivo',
	
			'DtScadenzaObiettivo' => 'Dt FineObiettivo',
	
			'MinPrevisti' => 'Min Previsti',
	
			'DtFineObiettivo' => 'Dt FineObiettivo',
	
			'NotaObiettivo' => 'Nota Obiettivo',
	
			'PercCompletamento' => 'Perc Completamento',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[Lavoro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLavoro()
    {
        return $this->hasMany(\common\models\busy\Lavoro::class,  ['IdObiettivo' => 'IdObiettivo']);
    }    

    /**
     * Gets query for [[DocObiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocobiettivo()
    {
        return $this->hasMany(\common\models\busy\DocObiettivo::class,  ['IdObiettivo' => 'IdObiettivo']);
    }    

    /**
     * Gets query for [[Soggetto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSoggetto()
    {
        return $this->hasOne(\common\models\soggetti\Soggetto::class,  ['IdSoggetto' => 'IdSoggetto',]);
    }    

    /**
     * Gets query for [[TipoOccupazione]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipooccupazione()
    {
        return $this->hasOne(\common\models\busy\TipoOccupazione::class,  ['TpOccup' => 'TpOccup',]);
    }    


}

