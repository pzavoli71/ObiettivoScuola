<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ztrans".
 *
 * @property int $idtrans
 * @property string|null $nometrans
 * @property string|null $ultagg
 * @property string|null $utente
 *
 * @property Zpermessi[] $zpermessis
 */
class ztrans extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ztrans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ultagg'], 'safe'],
            [['nometrans'], 'string', 'max' => 200],
            [['utente'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtrans' => 'Idtrans',
            'nometrans' => 'Nometrans',
            'ultagg' => 'Ultagg',
            'utente' => 'Utente',
        ];
    }

    /**
     * Gets query for [[Zpermessis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZpermessis()
    {
        return $this->hasMany(Zpermessi::class, ['idtrans' => 'idtrans']);
    }
}
