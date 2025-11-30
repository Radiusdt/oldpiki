<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DarkAsset::register($this);

$this->beginPage() ?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/template/mazer/assets/static/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="/template/mazer/assets/static/images/logo/favicon.png" type="image/png">

    <title><?= !empty($this->title) ? Html::encode(strip_tags($this->title)) : Html::encode(Yii::$app->name) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>

<body class="">
<?php $this->beginBody() ?>
<div id="app">
    <div id="sidebar">
        <?= $this->render('@app/views/layouts/_sidebar') ?>
    </div>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3><?= $this->title ?></h3>
                        <?php if (!empty($this->params['subtitle'])) { ?>
                        <p class="text-subtitle text-muted">
                            <?= $this->params['subtitle'] ?>
                        </p>
                        <?php } ?>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <?php if (!empty($this->params['links'])) { ?>
                                    <?php foreach ($this->params['links'] as $link) { ?>
                                    <li class="breadcrumb-item <?= !empty($link['active']) ? 'active' : '' ?>">
                                        <a class="<?= $link['class'] ?? '' ?>" href="<?= $link['url'] ?>"><?= $link['title'] ?></a>
                                    </li>
                                    <?php } ?>
                                <?php } ?>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>