<?php

/** @var yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<?php 
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
} ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    
    <!-- Aggiungere questo tag alle pagine con iframes altrimenti arrivano delle bad request con ajax -->
    <?= Html::csrfMetaTags() ?>    

    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">    
    
    <?php $this->registerJsFile(
    '@web/js/app.js',
    ['depends' => [\yii\web\JqueryAsset::class, \yii\jui\JuiAsset::class]]
    );?>
    <?php $this->registerJs(
    "setTimeout(function() {if (AppGlob) AppGlob.resize2(window)},300);",
    View::POS_READY,
    'resize-page-script'
    );?>
    
    <script src="/js/tabs.js"></script>    
    
    <?php $this->head() ?>

</head>

<body class="d-flex flex-column h-100">

<?php $this->beginBody() ?>

<header id="formheader">
</header>

<main id="main" class="flex-shrink-0" role="main">
        <?= $content ?>
</main>



<!--script language="javascript">
    setTimeout(function() {if (AppGlob) AppGlob.resize2(window)},300);
</script-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
