<?php

/** @var yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;

use common\components\NewNav;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => '@web/favicon.ico']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">    
	
	<?php $this->registerJsFile(
    '@web/js/app.js',
    ['depends' => [\yii\web\JqueryAsset::class, \yii\jui\JuiAsset::class]]
	);?>
	
    <script src="/js/tabs.js"></script>    
	<!-- ?php $this->registerJs(
		"$(document).ready(function() {Tabs.addTab('homepage','Home page','/index.php?r=quiz/index'); Tabs.addTab('login','Login Page','https:ffff'); Tabs.activateTab('homepage') });",
		yii\web\View::POS_READY,'my_script_id2'
	);
	?-->
	
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header" class="fixed-top">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark']
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['site/index']],
        ['label' => 'Obiettivi', 'url' => ['busy/obiettivo/index']],
        ['label' => 'Quiz',  'items' => [
            ['label' => 'Lista Quiz', 'url' => ['patente/quiz/index']]            
        ]],        
        ['label' => 'About', 'url' => ['site/about']],
        ['label' => 'Contact', 'url' => ['site/contact']],
        ['label' => 'Tabelle',  'items' => [
            ['label' => 'Lista Occupazioni', 'url' => ['busy/tipooccupazione/index']]            
        ]],        
        
    ];
    $menuItems = \frontend\controllers\SiteController::menu($menuItems);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    } else {
        $menuItems[] = ['label' => 'Modifica profilo', 'url' => ['/soggetti/soggetto/view&IdSoggetto=0',['IdSoggetto' => Yii::$app->user->identity]]];        
    }

    echo NewNav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }        
    ?>

	<?php
    NavBar::end();
    ?>
</header>

<div id="maintabs" class="flex-shrink-0" role="main">
    <div class="container" id="main-container">
		<div id="tabs-header"><ul></ul></div>
		<!--button class="btn btn-success" onclick="Tabs.addTab('prova','Elemento','/index.php?r=site/index')"></button-->
		<div class="tabs-container"></div>
        <?= Alert::widget() ?>
        <!--?= $content ?-->
    </div>
</div>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
