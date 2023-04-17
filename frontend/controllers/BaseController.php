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
}
