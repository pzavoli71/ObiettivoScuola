<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "Argomento".
 *

 * @property int	$IdArg,

 * @property string|null	$DsArgomento,

 * @property int	$IdArgPadre,

 */

class Argomento extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['IdArg','IdArgPadre'];
	public $datetime_columns = [];
	
	public static function tableName()
    {
        return 'do_argomento';
    }
	
    public function rules()
    {
        return [
			[['IdArg','IdArgPadre'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['DsArgomento'],'string','max' => 300],
			[[], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'IdArg' => 'Id Arg',
	
			'DsArgomento' => 'Ds Argomento',
	
			'IdArgPadre' => 'Id ArgPadre',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[TipoOccupazione]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipooccupazione()
    {
        return $this->hasMany(\common\models\busy\TipoOccupazione::class,  ['IdArg' => 'IdArg']);
    }    

    /**
     * Gets query for [[Obiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObiettivo()
    {
        return $this->hasMany(\common\models\busy\Obiettivo::class,  ['IdArg' => 'IdArg']);
    }    

    /**
     * Gets query for [[PermessoArg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermessoarg()
    {
        return $this->hasMany(\common\models\busy\PermessoArg::class,  ['IdArg' => 'IdArg']);
    }    


}

