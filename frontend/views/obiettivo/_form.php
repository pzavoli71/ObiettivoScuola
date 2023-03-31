<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="obiettivo-form">

    <?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
]); ?>

    <?= $form->field($model, 'IdObiettivo')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'IdSoggetto')->dropDownList($items) ?>
    <!--?= Html::activeDropDownList($model, 'IdSoggetto',$items) ?-->
    
    <?= $form->field($model, 'TpOccup')->dropDownList($itemsTpOccup) ?>

<?= $form->field($model, 'DtInizioObiettivo')->widget(DateControl::className(),
    ['type' => DateControl::FORMAT_DATETIME,
    //'ajaxConversion' => true,
    //'autoWidget' => true,
    //'widgetClass' => '',   
    //'displayFormat' => 'php:D, d-M-Y H:i:s A',
    //'saveFormat' => 'php:Y-m-d H:i:s',
    //'saveTimezone' => 'UTC',
    //'displayTimezone' => 'Europe/Rome',
    'saveOptions' => [
        'label' => 'Input saved as: ',
        'type' => 'text',
        'readonly' => true,
        'class' => 'hint-input text-muted'
    ],        
    'widgetOptions' => [
        'pluginOptions' => [
            'autoclose' => false,
            //'format' => 'php:d-F-Y h:i:s A'
        ]
    ]       
])?>
    
    <?= $form->field($model, 'DescObiettivo')->textArea(['rows' => 6]) ?>

<?= $form->field($model, 'DtScadenzaObiettivo')->widget(DateControl::className(),
    ['type'=>DateControl::FORMAT_DATETIME,       
        ]); 
?>
    
    <?= $form->field($model, 'MinPrevisti')->textInput() ?>

    <?= $form->field($model, 'DtFineObiettivo')->widget(DateControl::className(),
    ['type' => 'datetime',
])?>

    <?= $form->field($model, 'NotaObiettivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PercCompletamento')->textInput(['maxlength' => true]) ?>

    <!--?= $form->field($model, 'ultagg')->textInput() ?-->

    <!--?= $form->field($model, 'utente')->textInput(['maxlength' => true]) ?-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
