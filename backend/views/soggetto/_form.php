<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Soggetto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="soggetto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IdSoggetto')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'NomeSoggetto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EmailSogg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bRagazzo')->textInput() ?>

    <?= $form->field($model, 'CodISS')->textInput() ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <!--?= $form->field($model, 'ultagg')->textInput() ?-->

    <!--?= $form->field($model, 'utente')->textInput(['maxlength' => true]) ?-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
