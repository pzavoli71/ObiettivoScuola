<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace common\models;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;

/**
 * Description of BaseModel
 *
 * @author Paride
 */
class BaseModel extends \yii\db\ActiveRecord {
    
    public $number_columns = [];
    public $date_columns = [];
    public $datetime_columns = [];
    public $bool_columns = [];
    
      public function behaviors()
          {
            $params = [
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
                            } else {
                                return 'batch';
                            }                      
                      }
                  ],
              ];            
            return $params;
          }
          
          protected function convertiNumero($numero) {
                $conv = str_replace('.', '', $numero);
                $conv = str_replace(',', '.', $conv);  
                if (str_contains($conv, '.'))
                        $conv = (double) $conv;
                else
                    $conv = (int) $conv;
                return $conv;              
          }
          
          protected function convertiBoolInIntero($valore) {
                if ($valore == null)  {
                    return null;
                }
                if ( $valore instanceof string) {
                    if ( strlen($valore) == 0) {
                        return null;
                    }
                    if ( $valore == 'true') {
                        return -1;
                    } else {
                        return 0;
                    }
                }
                if ( $valore) {
                    return -1;
                }
                return 0;              
          }
          
          protected function convertiStringToDateTime($valore) {
              if ( $valore == null || $valore == '')
                  return null;
              $format = \common\config\db\mysql\ColumnSchema::$saveDateTimeFormat;
              $conv = \DateTime::createFromFormat($format, $valore);
              if (!$conv) 
                  throw new \UnexpectedValueException("Could not parse the date: " . $valore);
              return $conv;
          }
          
          protected function convertiStringToDate($valore) {
              if ( $valore == null || $valore == '')
                  return null;
              $format = \common\config\db\mysql\ColumnSchema::$saveDateFormat;
              $conv = \Dat::createFromFormat($format, $valore);
              if (!$conv) 
                  throw new \UnexpectedValueException("Could not parse the date: " . $valore);
              return $conv;
          }                    
          
          public function setAttributes($values, $safeOnly = true) {
              parent::setAttributes($values, $safeOnly);
            foreach ($this->number_columns as $nomecol) {
                if ( $this->attributes[$nomecol] != null) {
                    $val = $this->convertiNumero($this->attributes[$nomecol]);
                    $this->setAttribute($nomecol, $val);
                }
            }
            
            foreach ($this->bool_columns as $nomecol) {
                $val = $this->convertiBoolInIntero($this->attributes[$nomecol]);
                $this->setAttribute($nomecol, $val);
            }
            
            foreach ($this->datetime_columns as $nomecol) {
                $val = $this->convertiStringToDateTime($this->attributes[$nomecol]);
                $this->setAttribute($nomecol, $val);
            }
            
            foreach ($this->date_columns as $nomecol) {
                $val = $this->convertiStringToDate($this->attributes[$nomecol]);
                $this->setAttribute($nomecol, $val);
            }              
          }
          
          public function beforeSave($insert) {
            if ( !parent::beforeSave($insert)) {
                  return false;
            }
            
            return true;
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
