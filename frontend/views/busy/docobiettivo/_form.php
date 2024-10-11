
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
//use mihaildev\ckeditor\CKEditor;

/** @var yii\web\View $this */
/** @var common\models\busy\DocObiettivo $model */
/** @var yii\widgets\ActiveForm $form */


//Fix for closing icon (x) not showing up in dialog
$this->registerJs("
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'it-IT';

        document.getElementById('start').onclick = () => {
            recognition.start();
            document.getElementById('stop').removeAttribute(\"disabled\");
            document.getElementById('start').setAttribute(\"disabled\",\"true\");
        };
        document.getElementById('stop').onclick = () => {
            recognition.stop();
            document.getElementById('stop').setAttribute(\"disabled\",\"true\");
            document.getElementById('start').removeAttribute(\"disabled\");
        };

        recognition.onresult = (event) => {
            interim_transcript = '';
            final_transcript = '';
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                // If the result item is Final, add it to Final Transcript, Else add it to Interim transcript
                if (event.results[i].isFinal) {
                    final_transcript += event.results[i][0].transcript;
                } else {
                    interim_transcript += event.results[i][0].transcript;
                }
            }        
            //const transcript =  event.results[0][0].transcript;
            // event.results[event.resultIndex][0].transcript;
            contenuto = jQuery('#docobiettivo-notadoc').redactor('code.get');
            jQuery('#docobiettivo-notadoc').redactor('code.set',contenuto + final_transcript);
        };

        recognition.onerror = (event) => {
            console.error('Error occurred in recognition:', event.error);
        };",
            \yii\web\View::POS_READY
);
?>
<div class="docobiettivo-form">
    
        <button id="start">Start Recognition</button>
        <button id="stop" disabled>Stop Recognition</button>
        
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

<!--script>
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'it-IT';

        document.getElementById('start').onclick = () => {
            recognition.start();
            document.getElementById('stop').removeAttribute("disabled");
            document.getElementById('start').setAttribute("disabled","true");
        };
        document.getElementById('stop').onclick = () => {
            recognition.stop();
            document.getElementById('stop').setAttribute("disabled","true");
            document.getElementById('start').removeAttribute("disabled");
        };

        recognition.onresult = (event) => {
            debugger;
            const transcript =  event.results[0][0].transcript;
            // event.results[event.resultIndex][0].transcript;
            //document.getElementById('docobiettivo-notadoc').innerText += transcript + '\n';
            //document.getElementsByClassName('redactor-editor').innerText += transcript + '\n';
            contenuto = $('#docobiettivo-notadoc').redactor('code.get');
            $('#docobiettivo-notadoc').redactor('code.set',contenuto + transcript);
        };

        recognition.onerror = (event) => {
            console.error('Error occurred in recognition:', event.error);
        };
    </script-->
