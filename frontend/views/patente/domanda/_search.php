
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\patente\Domanda $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="domanda-search searchform">
    <style>
        .domanda-search .form-control {
            /*width:initial;*/
        }    
    </style>

    <fieldset>
        <legend>Inserisci il filtro</legend>
	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
        'action' => ['lista'],
        'method' => 'get',		
	]); ?>
	
	
	<?= $form->field($model,'IdDomanda') ?>	
		
	<?= $form->field($model,'IdCapitolo')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	<?= $form->field($model,'IdDom')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	<?= $form->field($model,'IdProgr')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
        <?= $form->field($model,'Asserzione')->textInput() ?>

        <?= $form->field($model,'bPatenteAB')->checkbox(['uncheck' => '0','value'=>'-1']); ?>		
		
		
	
    <div class="form-group-search">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	</fieldset>
</div>
