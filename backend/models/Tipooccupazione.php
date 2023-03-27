<?php

namespace app\models;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "tipooccupazione".
 *
 * @property int $TpOccup
 * @property string $DsOccup
 * @property string $ultagg
 * @property string $utente
 *
 * @property Obiettivo[] $obiettivos
 */
class Tipooccupazione extends BaseModel
{
    protected $utente;
    protected $ultagg;
    /**private $utente;
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipooccupazione';
    }

      public function behaviors()
          {
            return array_merge(
                parent::behaviors(),         
                    /*[
                    'timestamp' => [
                         'class' => 'yii\behaviors\TimestampBehavior',
                         'attributes' => [
                             ActiveRecord::EVENT_BEFORE_INSERT => ['ultagg'],
                             ActiveRecord::EVENT_BEFORE_UPDATE => ['ultagg'],
                         ],
                         'value' => new Expression('NOW()'),
                     ],                  
                  'blameable' => [
                      'class' => BlameableBehavior::className(),
                      'createdByAttribute' => 'utente',
                      'updatedByAttribute' => 'utente',
                        'value' => function ($event) {
                            if(isset(\Yii::$app->user->identity->username)) {                                
                                return \Yii::$app->user->identity->username;
                            }                      
                        }
                  ],
              ]*/
            );
          }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TpOccup'], 'required'],
            [['TpOccup'], 'integer'],
            [['ultagg'], 'safe'],
            [['DsOccup'], 'string', 'max' => 200],
            [['utente'], 'string', 'max' => 20],
            [['TpOccup'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TpOccup' => 'Tp Occup',
            'DsOccup' => 'Ds Occup',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[Obiettivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObiettivos()
    {
        return $this->hasMany(Obiettivo::class, ['TpOccup' => 'TpOccup']);
    }
}
