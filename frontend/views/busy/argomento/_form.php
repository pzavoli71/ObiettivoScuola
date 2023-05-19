
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\Argomento $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="argomento-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdArg')->hiddenInput()->label(false) ?>	
		
		<?= $form->field($model,'DsArgomento')->textInput() ?>
		
	<?= $form->field($model,'IdArgPadre')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	
	<!--?= $form->field($model, 'imageFile')->fileInput() ?--> <!-- Scommentare per fare fileupload -->
	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
