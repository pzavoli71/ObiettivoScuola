<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DocobiettivoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="docobiettivo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdObiettivo') ?>

    <?= $form->field($model, 'IdDocObiettivo') ?>

    <?= $form->field($model, 'DtDoc') ?>

    <?= $form->field($model, 'PathDoc') ?>

    <?= $form->field($model, 'NotaDoc') ?>

    <?php // echo $form->field($model, 'ultagg') ?>

    <?php // echo $form->field($model, 'utente') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
