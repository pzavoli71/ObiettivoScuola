<?php
namespace common\models\busy;

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * This is the model class for table "DocObiettivo".
 *

 * @property int	$IdObiettivo,

 * @property int	$IdDocObiettivo,

 * @property string|DateTime|null	$DtDoc,

 * @property string|null	$PathDoc,

 * @property string|null	$NotaDoc,

 */

class DocObiettivo extends \common\models\BaseModel
{
	public $bool_columns = [];
	public $number_columns = ['IdObiettivo','IdDocObiettivo'];
	public $datetime_columns = ['DtDoc'];
	
	public static function tableName()
    {
        return 'DocObiettivo';
    }
	
    public function rules()
    {
        return [
			[['IdObiettivo','IdDocObiettivo'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[['PathDoc'],'string','max' => 1000],
			[['NotaDoc'],'string','max' => 100000],
			[['DtDoc'], 'safe'],
        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'IdObiettivo' => 'Id Obiettivo',
	
			'IdDocObiettivo' => 'Id DocObiettivo',
	
			'DtDoc' => 'Dt Doc',
	
			'PathDoc' => 'Path Doc',
	
			'NotaDoc' => 'Nota Doc',
	
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

    public function beforeSave($insert): bool {
        if ( !parent::beforeSave($insert))
            return false;
        $nota = $this->NotaDoc;
        /*if (str_contains($nota, "https://www.youtube.com")) {
            $nota = str_replace('watch?v=', 'embed/', $nota);
            $nota = '<iframe width="560" height="315" src="' .$nota. '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';            
            $this->NotaDoc= $nota;
        }*/
        return true;
    }

}

