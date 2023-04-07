<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "docobiettivo".
 *
 * @property int $IdObiettivo
 * @property int $IdDocObiettivo
 * @property string|null $DtDoc
 * @property string $PathDoc
 * @property string $NotaDoc
 * @property string $ultagg
 * @property string $utente
 *
 * @property Obiettivo $idObiettivo
 */
class Docobiettivo extends \common\models\BaseModel
{
     public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'docobiettivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdObiettivo'], 'integer'],
            [['DtDoc', 'ultagg'], 'safe'],
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,JPG'],
            [['PathDoc'], 'string', 'max' => 1000],
            [['NotaDoc'], 'string', 'max' => 2000],
            [['utente'], 'string', 'max' => 20],
            [['IdObiettivo'], 'exist', 'skipOnError' => true, 'targetClass' => Obiettivo::class, 'targetAttribute' => ['IdObiettivo' => 'IdObiettivo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdObiettivo' => 'Id Obiettivo',
            'IdDocObiettivo' => 'Id Doc Obiettivo',
            'DtDoc' => 'Dt Doc',
            'PathDoc' => 'Path Doc',
            'NotaDoc' => 'Nota Doc',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[IdObiettivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdObiettivo()
    {
        return $this->hasOne(Obiettivo::class, ['IdObiettivo' => 'IdObiettivo']);
    }
    
    public function upload()
    {
        //if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        //} else {
        //    return false;
        //}
    }    
}
