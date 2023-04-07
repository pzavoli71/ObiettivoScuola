<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\Docobiettivo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="docobiettivo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IdDocObiettivo')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'IdObiettivo')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'DtDoc')->widget(DateControl::className(),
    ['type' => 'datetime',
])?>

    <?= $form->field($model, 'PathDoc')->fileInput() ?>
    
    <?= $form->field($model, 'NotaDoc')->textInput(['maxlength' => true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
