<?php
namespace common\models\patente;

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "DomandeSbagliate".
 *

 * @property int	$ConteggioErrori,

 * @property int	$ConteggioQuanteVolte,

 */

class DomandeSbagliate extends ActiveRecord // \common\models\BaseModel
{
    public $ConteggioErrori;
    public $ConteggioQuanteVolte;
    public static function tableName()
    {
        return 'esa_domanda';
    }
	
    public function rules()
    {
        return [
			[['ConteggioErrori','ConteggioQuanteVolte'], 'integer'],
			[[], 'boolean','trueValue'=>'-1'],
			[[], 'safe'],
			//['DtFineTess', 'compare', 'compareAttribute' => 'DtInizioTess', 'operator' => '>=','enableClientValidation'=>false],
			//[['CdRuolo','IdSocieta','IdSoggetto','DtInizioTess'], 'required'],

        ];
    }	
	
    public function attributeLabels()
    {
        return [
	
			'ConteggioErrori' => 'Conteggio Errori',
	
			'ConteggioQuanteVolte' => 'Conteggio QuanteVolte',
	
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }	




    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ( !$insert) 
            return true;
        
        // Aggiungo anche il gruppo per questo utente
        //$zutgr = new zutgr();
        //$zutgr->id = $this->id;
        //$zutgr->idgruppo = 1;
        
        //if ( $zutgr->save())
        //    return true;
        //return false;
		return true;
    }

}

