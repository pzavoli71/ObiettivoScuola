<?php
namespace common\models\soggetti;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "Soggetto".
 *

 * @property int	$id,

 * @property int	$IdSoggetto,

 * @property string|null	$NomeSoggetto,

 * @property string|null	$EmailSogg,

 * @property boolean	$bRagazzo,

 * @property int	$CodISS,

 */

class Soggetto extends \common\models\BaseModel
{
	public $bool_columns = ['bRagazzo'];
	public $number_columns = ['id','IdSoggetto','CodISS'];
	public $datetime_columns = [];
	
	public static function tableName()
    {
        return 'Soggetto';
    }
	
    public function rules()
    {
        return [
			[['id','IdSoggetto'], 'integer'],
			[['bRagazzo'], 'boolean','trueValue'=>'-1'],
			[['NomeSoggetto'],'string','max' => 50],
			[['EmailSogg'],'string','max' => 200],
                        [['EmailSogg'],'email'],            
			[['CodISS'], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'id' => 'id',
	
			'IdSoggetto' => 'Id Soggetto',
	
			'NomeSoggetto' => 'Nome Soggetto',
	
			'EmailSogg' => 'Email Sogg',
	
			'bRagazzo' => 'bRagazzo',
	
			'CodISS' => 'Cod ISS',
	
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
        return $this->hasMany(\common\models\soggetti\Obiettivo::class,  ['IdSoggetto' => 'IdSoggetto']);
    }    

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\soggetti\User::class,  ['id' => 'id']);
    }    


}

