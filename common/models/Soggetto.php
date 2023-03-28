<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "soggetto".
 *
 * @property int $IdSoggetto
 * @property string $NomeSoggetto
 * @property string $EmailSogg
 * @property int $bRagazzo
 * @property int $CodISS
 * @property int|null $id
 * @property string $ultagg
 * @property string $utente
 *
 * @property User $id0
 * @property Obiettivo[] $obiettivos
 */
class Soggetto extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'soggetto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bRagazzo', 'CodISS', 'id'], 'integer'],
            [['ultagg'], 'safe'],
            [['NomeSoggetto'], 'string', 'max' => 50],
            [['EmailSogg'], 'string', 'max' => 200],
            [['utente'], 'string', 'max' => 20],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdSoggetto' => 'Id Soggetto',
            'NomeSoggetto' => 'Nome Soggetto',
            'EmailSogg' => 'Email Sogg',
            'bRagazzo' => 'B Ragazzo',
            'CodISS' => 'Cod Iss',
            'id' => 'ID',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Obiettivos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObiettivos()
    {
        return $this->hasMany(Obiettivo::class, ['IdSoggetto' => 'IdSoggetto']);
    }
}
