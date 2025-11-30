<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- page-header -->
<div class="page-header">
    <h1 class="page-title"><span class="subpage-title"><?= Html::encode($this->title) ?></h1>
    <div class="ml-auto">
        <div class="input-group">
            <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-info btn-icon mr-2" data-toggle="tooltip"
               title="" data-placement="bottom" data-original-title="Add New">
                <span>
                    <i class="fe fe-plus"></i> Create
                </span>
            </a>
        </div>
    </div>
</div>
<!-- End page-header -->

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <div>
                    <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                </div>
            </div>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'id',
                        'name',
                        'advertiser',
                        'offer',
                        'source',
                        'goal',
                        'status',
                        'url',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                        ],
                    ],
                ]); ?>
            </div>
            <!-- table-responsive -->
        </div>
    </div><!-- col end -->
</div>


<?php $this->registerCss('.page-main > .container {max-width: 100%;}'); ?>
