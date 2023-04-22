
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\soggetti\Soggetto $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="soggetto-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'id') ->dropDownList(
			$combo['User'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'IdSoggetto')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
		<?= $form->field($model,'NomeSoggetto')->textInput() ?>
		
		<?= $form->field($model,'EmailSogg')->textInput() ?>
		
		<?= $form->field($model,'bRagazzo')->checkbox(['uncheck' => '0','value'=>'-1']); ?>		
		
	<?= $form->field($model,'CodISS')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
