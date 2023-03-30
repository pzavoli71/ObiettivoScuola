<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DateTimePicker;

/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="obiettivo-form">

    <?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
]); ?>

    <?= $form->field($model, 'IdObiettivo')->hiddenInput()->label(false) ?>

    <!--?= $form->field($model, 'IdSoggetto')->textInput() ?-->
    <?= $form->field($model, 'IdSoggetto')->dropDownList($items) ?>
    <!--?= Html::activeDropDownList($model, 'IdSoggetto',$items) ?-->
    
    <?= $form->field($model, 'TpOccup')->dropDownList($itemsTpOccup) ?>

    <!--?= $form->field($model, 'DtInizioObiettivo')->textInput(['maxlength' => true]) ?-->
    <?= $form->field($model, 'DtInizioObiettivo')->widget(\yii\jui\DateTimePicker::className(),
    [ 'dateFormat' => 'dd/MM/yyyy',
      'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true
      ]])
    ->textInput(['placeholder' => \Yii::t('app', 'dd/mm/yyyy')]) ;?>
    
    <?= $form->field($model, 'DescObiettivo')->textArea(['rows' => 6]) ?>

    <?= $form->field($model, 'DtScadenzaObiettivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MinPrevisti')->textInput() ?>

    <?= $form->field($model, 'DtFineObiettivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NotaObiettivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PercCompletamento')->textInput(['maxlength' => true]) ?>

    <!--?= $form->field($model, 'ultagg')->textInput() ?-->

    <!--?= $form->field($model, 'utente')->textInput(['maxlength' => true]) ?-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
