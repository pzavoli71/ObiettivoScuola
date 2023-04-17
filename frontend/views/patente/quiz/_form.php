<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\money\MaskMoney;
/** @var yii\web\View $this */
/** @var common\models\patente\Quiz $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="quiz-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
		<?= $form->field($model,'CdUtente')->textInput() ?>
	
		<?= $form->field($model,'IdQuiz')->textInput() ?>
	
		<?= $form->field($model,'DtCreazioneTest')->widget(DateControl::className(),
    ['type'=>DateControl::FORMAT_DATETIME,  
        'convertFormat'=>false,
        ]); 
?>
	
		<?= $form->field($model,'DtInizioTest')->textInput() ?>
	
		<?= $form->field($model,'EsitoTest')->widget(\yii\widgets\MaskedInput::className(),
                    \frontend\controllers\BaseController::$MASK_DECIMAL_PARAMS_WIDGET,
                    ); ?>

	
		<?= $form->field($model,'DtFineTest')->textInput() ?>
	
		<!--?= $form->field($model,'bRispSbagliate')->textInput(['type' => 'number'])->label('Risposte sbagliate') ?-->
                <?= $form->field($model,'bRispSbagliate')->checkbox(['uncheck' => '0','value'=>'-1'])->label('Risposte sbagliate'); ?>
                <!--?= $form->field($model, 'bRispSbagliate', ['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->bRispSbagliate,0)]]) ?-->
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
