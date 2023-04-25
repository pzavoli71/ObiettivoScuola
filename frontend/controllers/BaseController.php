<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author Paride
 */
class BaseController  extends Controller{
    public static $MASK_DECIMAL_PARAMS_WIDGET = [
                    'clientOptions' => [
                    'alias' => 'decimal',
                    'digits' => 2,
                    'digitsOptional' => false,
                    'radixPoint' => ',',
                    'groupSeparator' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                    ]];
    public static $MASK_INTEGER_PARAMS_WIDGET = [
                    'clientOptions' => [
                    'alias' => 'decimal',
                    'digits' => 0,
                    'digitsOptional' => false,
                    'radixPoint' => ',',
                    'groupSeparator' => '.',
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                    ]];
    public $DatiCombo = [];
    
    protected function addCombo($name, $items) {
        $this->DatiCombo[$name] = $items;
    }
    
    public function render($view, $params = [])
    {
        if ( !empty($this->DatiCombo)) {
            $pars = [];
            $pars['model'] = $params['model'];
            $combo = [];
            foreach ($this->DatiCombo as $key => $value) {
                $combo[$key] = $value;
            }
            $pars['combo'] = $combo; // $this->DatiCombo;
            $params = $pars;
            //$params = array_merge($params,$this->DatiCombo);
        }
        $content = $this->getView()->render($view, $params, $this);
        return $this->renderContent($content);
    }
    
    public function upload($imageFile)
    {
        $imageFile->saveAs('uploads/' . $imageFile->baseName . '.' . $imageFile->extension);
        return true;
    }       
}
