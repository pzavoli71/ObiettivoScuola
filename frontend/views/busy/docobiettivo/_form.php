
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\DocObiettivo $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="docobiettivo-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdObiettivo') ->hiddenInput()->label(false); ?>

	<?= $form->field($model,'IdDocObiettivo')->hiddenInput()->label(false); ?>	
		
		<?= $form->field($model,'DtDoc')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>				
				
		<?= $form->field($model,'PathDoc')->textInput(['readonly'=>true]) ?>
		
		<?= $form->field($model,'NotaDoc')->textarea(['rows' => '7']) ?>
		
                <?= $form->field($model, 'imageFile')->fileInput() ?> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
