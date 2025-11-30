<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PostbackSetting */

$this->title = 'Create Settings';
$this->params['breadcrumbs'][] = ['label' => 'Proxies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- page-header -->
<div class="page-header">
    <h1 class="page-title"><span class="subpage-title"><?= Html::encode($this->title) ?></h1>
    <div class="ml-auto">
        <div class="input-group">
            <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="btn btn-warning btn-icon mr-2" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Chat">
                <span>
                    <i class="fe fe-corner-up-left"></i> Back
                </span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-info btn-icon mr-2" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
                <span>
                    <i class="fe fe-plus"></i> Create
                </span>
            </a>
        </div>
    </div>
</div>
<!-- End page-header -->
<?= $this->render('_form', [
'model' => $model,
]) ?>