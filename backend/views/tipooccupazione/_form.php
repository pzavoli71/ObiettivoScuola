<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoOccupazione $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-occupazione-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TpOccup')->textInput() ?>

    <?= $form->field($model, 'DsOccup')->textInput(['maxlength' => true]) ?>

    <!--?= $form->field($model, 'ultagg')->textInput() ?-->

    <!--?= $form->field($model, 'utente')->textInput(['maxlength' => true]) ?-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
