
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\Argomento $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="argomento-search searchform">
    <style>
        .argomento-search .form-control {
            /*width:initial;*/
        }    
    </style>

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
        'action' => ['index'],
        'method' => 'get',		
	]); ?>
	
	
	<?= $form->field($model,'IdArg')->hiddenInput() ?>	
		
		<?= $form->field($model,'DsArgomento')->textInput() ?>
		
	<?= $form->field($model,'IdArgPadre')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	
    <div class="form-group-search">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
