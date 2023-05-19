<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "TipoPermesso".
 *

 * @property int	$TpPermesso,

 * @property string|null	$DsPermesso,

 */

class TipoPermesso extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['TpPermesso'];
	public $datetime_columns = [];
	public $auto_increment_cols = ['TpPermesso' ];
	
	public static function tableName()
    {
        return 'tipopermesso';
    }
	
    public function rules()
    {
        return [
			[['TpPermesso'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['DsPermesso'],'string','max' => 100],
			[[], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'TpPermesso' => 'Tp Permesso',
	
			'DsPermesso' => 'Ds Permesso',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	


    /**
     * Gets query for [[PermessoArg]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPermessoarg()
    {
        return $this->hasMany(\common\models\busy\PermessoArg::class,  ['TpPermesso' => 'TpPermesso']);
    }    


}

