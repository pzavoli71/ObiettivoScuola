
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\Lavoro $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="lavoro-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdObiettivo') ->hiddenInput()->label(false); ?>

	<?= $form->field($model,'IdLavoro')->hiddenInput()->label(false); ?>	
		
		<?= $form->field($model,'DtLavoro')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATE,  
			'convertFormat'=>false,
			]); 
		?>				
				
	<?= $form->field($model,'OraInizio')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	<?= $form->field($model,'MinutiInizio')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
		<?= $form->field($model,'NotaLavoro')->textArea() ?>
		
	<?= $form->field($model,'OraFine')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	<?= $form->field($model,'MinutiFine')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
