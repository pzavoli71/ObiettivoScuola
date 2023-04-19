
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
	
	
	<?= $form->field($model,'IdQuiz') ->dropDownList(
			$combo['Quiz'],           // Flat array ('id'=>'label')
			['prompt'=>'pippo', 'value'=>$model->IdQuiz]    // options
	); ?>

	<!--?= $form->field($model,'IdDomanda') ->dropDownList(
			$combo['Domanda'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?-->

	<?= $form->field($model,'IdDomandaTest')->hiddenInput() ?>	
		

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
