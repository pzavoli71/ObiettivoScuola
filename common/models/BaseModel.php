<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace common\models;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
/**
 * Description of BaseModel
 *
 * @author Paride
 */
class BaseModel extends \yii\db\ActiveRecord {
      public function behaviors()
          {
              return [
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
              ];
          }
          
          protected function validaDaStringaAData($nomeparametro, $valore) {
            if ( $valore === null || strlen($valore) == 0)
                return true;
            $parsed = \DateTime::createFromFormat('Y-m-d H:i:s', $valore);        
            if ( $parsed)
                return true;
            $parsed = \DateTime::createFromFormat('dmY', $valore);        
            if ( !$parsed) {
                $this->addError($nomeparametro, 'il campo ' . $nomeparametro . ' non è valido');     
                return false;
            }
            return true;
          }
          
          protected function convertiDaStringaAData($nomeparametro, $valore) {
            if ( $valore === null || strlen($valore) == 0)
                return true;
            $parsed = \DateTime::createFromFormat('d/m/Y H:i', $valore);        
            if ( $parsed)
                return true;
            $parsed = \DateTime::createFromFormat('dmY', $valore);        
            if ( !$parsed) {
                $this->addError($nomeparametro, 'il campo ' . $nomeparametro . ' non è valido');     
                return false;
            }
            $formatted = \Yii::$app->formatter->asDate($parsed, 'php:d/m/Y');
            $this[$nomeparametro] = $formatted;
          }
}
