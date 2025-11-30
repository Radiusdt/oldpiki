<?php
return [
    'definitions' => [
        yii\grid\GridView::class     => [
            'tableOptions' => [
                'class' => 'table table-lg',
            ],
            'options' => [
                'class' => 'table-responsive',
            ],
            'layout'       => "{items}\n{pager}",
        ],
        yii\grid\ActionColumn::class => [
            'template' => '{update} {delete}',
            'buttons'  => [
                'view' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-eye-fill"></i>', $url, [
                        'title' => Yii::t('yii', 'View'),
                        'class' => 'btn btn-outline-primary',
                    ]);
                },
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-pen-fill"></i>', $url, [
                        'title' => Yii::t('yii', 'Update'),
                        'class' => 'btn btn-outline-warning',
                        'data-pjax' => 0,
                    ]);
                },
                'login' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-eye-fill"></i>', $url, [
                        'title' => Yii::t('yii', 'Login'),
                        'class' => 'btn btn-outline-primary',
                    ]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-trash-fill"></i>', $url, [
                        'title'        => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method'  => 'post',
                        'class' => 'btn btn-outline-danger delete-button ',
                    ]);
                },
                'accept' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-hand-thumbs-up-fill"></i>', $url, [
                        'title' => 'Accept',
                        'class' => 'btn btn-outline-success',
                    ]);
                },
                'decline' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-hand-thumbs-down-fill"></i>', $url, [
                        'title' => 'Decline',
                        'class' => 'btn btn-outline-warning',
                    ]);
                },
                'clear' => function($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-trash-fill"></i>', $url, [
                        'title' => 'Clear',
                        'class' => 'btn btn-outline-danger',
                    ]);
                },
                'refresh' => function ($url, $model) {
                    return \yii\helpers\Html::a('<i class="bi bi-arrow-clockwise"></i>', $url, [
                        'title' => 'Refresh',
                        'class' => 'btn btn-outline-success',
                    ]);
                },
            ]
        ],
        \yii\widgets\ActiveField::class => [
            'template' => "<div class=\"form-line\">{label}\n{input}\n{error}</div>",
            'options' => [
                'class' => 'form-group form-float',
            ]
        ],
        \yii\widgets\ActiveForm::class => [
            'errorSummaryCssClass' => 'alert alert-danger',
            'options' => [
                'class' => 'form form-vertical',
            ]
        ],
        \yii\widgets\LinkPager::class => [
            'pageCssClass' => 'page-item',
            'linkOptions' => [
                'class' => 'page-link',
            ],
            'disabledPageCssClass' => 'page-link',
        ]
    ],
];