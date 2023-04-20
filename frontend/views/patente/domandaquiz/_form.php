
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\patente\DomandaQuiz $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="domandaquiz-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdQuiz') ->hiddenInput()->label(false);
	 ?>

	<?= $form->field($model,'IdDomanda') ->dropDownList(
			$combo['Domanda'],           // Flat array ('id'=>'label')
			['prompt'=>'', 'value'=>$model->IdDomanda]    // options
	); ?>

	<?= $form->field($model,'IdDomandaTest')->hiddenInput()->label(false) ?>	
		

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
