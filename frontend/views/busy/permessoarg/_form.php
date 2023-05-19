
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\PermessoArg $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="permessoarg-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdSoggetto') ->dropDownList(
			$combo['Soggetto'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'IdArg') ->dropDownList(
			$combo['Argomento'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'TpPermesso') ->dropDownList(
			$combo['TipoPermesso'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'IdPermessoArg')->hiddenInput() ?>	
		
	
	<!--?= $form->field($model, 'imageFile')->fileInput() ?--> <!-- Scommentare per fare fileupload -->
	
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
