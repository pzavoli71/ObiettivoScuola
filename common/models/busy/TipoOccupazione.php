<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "TipoOccupazione".
 *

 * @property int	$TpOccup,

 * @property string|null	$DsOccup,

 */

class TipoOccupazione extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = [];
	public $datetime_columns = [];
	public $auto_increment_cols = ['TpOccup'];
        
	public static function tableName()
    {
        return 'tipooccupazione';
    }
	
    public function rules()
    {
        return [
			[['TpOccup'], 'integer'],
			//[[], 'boolean','trueValue'=>'-1'],
			[['DsOccup'],'string','max' => 200],
			[['TpOccup','IdArg'], 'safe'],
                        //[['TpOccup'], 'required'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'TpOccup' => 'Tp Occup',
	
			'DsOccup' => 'Ds Occup',
            
			'IdArg' => 'Argomento',
	
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
        return $this->hasMany(\common\models\Obiettivo::class,  ['TpOccup' => 'TpOccup']);
    }    
    /**
     * Gets query for [[Argomento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArgomento()
    {
        return $this->hasOne(\common\models\busy\Argomento::class,  ['IdArg' => 'IdArg']);
    }    


}

