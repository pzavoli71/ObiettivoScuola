<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "PermessoArg".
 *

 * @property int	$IdSoggetto,

 * @property int	$IdArg,

 * @property int	$TpPermesso,

 * @property int	$IdPermessoArg,

 */

class PermessoArg extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['IdSoggetto','IdArg','TpPermesso','IdPermessoArg'];
	public $datetime_columns = [];
	public $auto_increment_cols = [ ];
	
	public static function tableName()
    {
        return 'permessoarg';
    }
	
    public function rules()
    {
        return [
			[['IdSoggetto','IdArg','TpPermesso','IdPermessoArg'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[[], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'IdSoggetto' => 'Id Soggetto',
	
			'IdArg' => 'Id Arg',
	
			'TpPermesso' => 'Tp Permesso',
	
			'IdPermessoArg' => 'Id PermessoArg',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
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
     * Gets query for [[Argomento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArgomento()
    {
        return $this->hasOne(\common\models\busy\Argomento::class,  ['IdArg' => 'IdArg']);
    }    

    /**
     * Gets query for [[TipoPermesso]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipopermesso()
    {
        return $this->hasOne(\common\models\busy\TipoPermesso::class,  ['TpPermesso' => 'TpPermesso',]);
    }    


}

