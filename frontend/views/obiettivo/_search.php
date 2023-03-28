<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ObiettivoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="obiettivo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdObiettivo') ?>

    <?= $form->field($model, 'IdSoggetto') ?>

    <?= $form->field($model, 'TpOccup') ?>

    <?= $form->field($model, 'DtInizioObiettivo') ?>

    <?= $form->field($model, 'DescObiettivo') ?>

    <?php // echo $form->field($model, 'DtScadenzaObiettivo') ?>

    <?php // echo $form->field($model, 'MinPrevisti') ?>

    <?php // echo $form->field($model, 'DtFineObiettivo') ?>

    <?php // echo $form->field($model, 'NotaObiettivo') ?>

    <?php // echo $form->field($model, 'PercCompletamento') ?>

    <?php // echo $form->field($model, 'ultagg') ?>

    <?php // echo $form->field($model, 'utente') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
