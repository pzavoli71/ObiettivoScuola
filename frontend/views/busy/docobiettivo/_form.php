
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
//use kartik\editors\Summernote;
//use kartik\form\ActiveForm;
//use froala\froalaeditor\FroalaEditorWidget;
//use dosamigos\tinymce\TinyMce;
//use floor12\summernote\Summernote;
//use marqu3s\summernote\Summernote;
use mihaildev\ckeditor\CKEditor;

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
    

		<?= $form->field($model,'NotaDoc')->widget(\common\components\NewRedactor::className());?>
                <!--/*        
                        ->widget(FroalaEditorWidget::class, [
                    'clientOptions' => [
                       'toolbarInline'=> false,
                        'theme' =>'royal', //optional: dark, red, gray, royal
                        'language'=>'it', // optional: ar, bs, cs, da, de, en_ca, en_gb, en_us ...
                        'height' => 200,
                        //'toolbarButtons' => ['fullscreen', 'bold', 'italic', 'underline', '|', 'paragraphFormat', 'insertImage'],
                        'imageUploadParam' => 'file',
                        'imageUploadURL' => \yii\helpers\Url::to(['site/upload/'])                        
                    ],
                    //'clientPlugins'=> ['fullscreen', 'paragraph_format', 'image']
                ]);*/
                /*->widget(Summernote::class, [
                    'useKrajeePresets' => true,
                    // other widget settings
                ]);*/
                //->textarea(['rows' => '7']) ?-->
		
                <?= $form->field($model, 'imageFile')->fileInput() ?> 

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
