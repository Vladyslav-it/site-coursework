<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$this->registerCssFile('@web/css/breadcrumb.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/images/logo.png', ['alt' => 'YourHealth', 'height' => '50']),

            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-lg navbar-dark my-header bg-dark fixed-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => array_merge(
                [
                    ['label' => 'Пости', 'url' => ['/post/index']],
                    ['label' => 'Про блог', 'url' => ['/site/about']],

                ],
                Yii::$app->user->isGuest
                    ? [
                        ['label' => 'Увійти', 'url' => ['/auth/login']],
                        ['label' => 'Реєстрація', 'url' => ['/auth/signup']],
                    ]
                    : array_merge(
                        // Адмін бачить Мої пости і категорії
                        Yii::$app->user->identity->isAdmin == 1
                            ? [
                                ['label' => 'Мої пости', 'url' => ['/admin/posts/index']],
                                ['label' => 'Мої категорії', 'url' => ['/admin/category/index']],
                            ]
                            : [],
                        //  авторизований користувач бачить Вихід
                        [
                            [
                                'label' => 'Вийти (' . Yii::$app->user->identity->name . ')',
                                'url' => ['/auth/logout'],
                                'linkOptions' => ['data-method' => 'post', 'class' => 'logout'],
                            ]
                        ]
                    )
            )
        ]);

        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Головна',
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => $this->params['breadcrumbs'],
                ]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; YourHealth <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end">Тобі тут сподобається 😉</div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>