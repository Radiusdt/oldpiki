<?php

/* @var $this \yii\web\View */
/* @var $content string */

\app\assets\OuterAsset::register($this);

$this->beginPage() ?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= \yii\helpers\Html::csrfMetaTags() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/template/mazer/assets/static/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="/template/mazer/assets/static/images/logo/favicon.png" type="image/png">

    <title><?= \yii\helpers\Html::encode(Yii::$app->name), (!empty($this->title) ? (': ' . \yii\helpers\Html::encode($this->title)) : '') ?></title>
    <?php $this->head() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
</head>

<body>
<?php $this->beginBody() ?>
<div id="auth">
    <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>