<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
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
    <!--?= $form->field($model, 'DtInizioObiettivo')->widget(\yii\jui\DatePicker::className(),
    [ 'dateFormat' => 'dd/MM/yyyy',
      'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true
      ]])
    ->textInput(['placeholder' => \Yii::t('app', 'dd/mm/yyyy')]) ;?-->

<?= $form->field($model, 'DtInizioObiettivo')->widget(DateTimePicker::className(),
    ['type' => DateTimePicker::TYPE_INPUT,
    'value' => '23-Feb-1982 10:10',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy hh:ii'
    ]
])->textInput(['placeholder' => \Yii::t('app', 'dd/mm/yyyy')]) ;?>
    
    <?= $form->field($model, 'DescObiettivo')->textArea(['rows' => 6]) ?>

<?= $form->field($model, 'DtScadenzaObiettivo')->widget(DateTimePicker::className(),
    ['type' => DateTimePicker::TYPE_INPUT,
    'value' => '23-Feb-1982 10:10',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy hh:ii'
    ]
])->textInput(['placeholder' => \Yii::t('app', 'dd/mm/yyyy')]) ;?>
    
    <?= $form->field($model, 'MinPrevisti')->textInput() ?>

    <?= $form->field($model, 'DtFineObiettivo')->widget(DateTimePicker::className(),
    ['type' => DateTimePicker::TYPE_INPUT,
    'value' => '23-Feb-1982 10:10',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd/mm/yyyy hh:ii'
    ]
])->textInput(['placeholder' => \Yii::t('app', 'dd/mm/yyyy')]) ;?>

    <?= $form->field($model, 'NotaObiettivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PercCompletamento')->textInput(['maxlength' => true]) ?>

    <!--?= $form->field($model, 'ultagg')->textInput() ?-->

    <!--?= $form->field($model, 'utente')->textInput(['maxlength' => true]) ?-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
