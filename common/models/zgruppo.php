<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zgruppo".
 *
 * @property int $idgruppo
 * @property string|null $nomegruppo
 * @property string|null $utente
 * @property string|null $ultagg
 *
 * @property Zpermessi[] $zpermessis
 * @property Zutgr[] $zutgrs
 */
class zgruppo extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zgruppo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ultagg'], 'safe'],
            [['nomegruppo'], 'string', 'max' => 200],
            [['utente'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idgruppo' => 'Idgruppo',
            'nomegruppo' => 'Nomegruppo',
            'utente' => 'Utente',
            'ultagg' => 'Ultagg',
        ];
    }

    /**
     * Gets query for [[Zpermessis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZpermessis()
    {
        return $this->hasMany(Zpermessi::class, ['idgruppo' => 'idgruppo']);
    }

    /**
     * Gets query for [[Zutgrs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZutgrs()
    {
        return $this->hasMany(Zutgr::class, ['idgruppo' => 'idgruppo']);
    }
}
