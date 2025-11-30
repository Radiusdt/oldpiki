<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostbackSetting */
/* @var $form yii\widgets\ActiveForm */
/* @var $providerList array */
/* @var $countryList array */
?>


<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-8 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header border-0">
                <div>
                    <h3 class="card-title">Basics</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="proxy-form">

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>

            </div>
            <!-- table-responsive -->
        </div>
        <div class="card">
            <div class="card-header border-0">
                <div>
                    <h3 class="card-title">Filters</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="proxy-form">
                    <?= $form->field($model, 'advertiser')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'offer')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'goal')->textInput() ?>

                    <?= $form->field($model, 'status')->dropDownList(\app\models\Lead::statuses(), ['prompt' => '[ any ]']) ?>
                </div>

            </div>
            <!-- table-responsive -->
        </div>
        <div class="card">
            <div class="card-header border-0">
                <div>
                    <h3 class="card-title">Postback</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="proxy-form">
                    <?= $form->field($model, 'url')->textarea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'method')->dropDownList($model::methods()) ?>

                    <?= $form->field($model, 'body')->textarea() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

            </div>
            <!-- table-responsive -->
        </div>
    </div><!-- col end -->
    <div class="col-md-8 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header border-0">
                <div>
                    <h3 class="card-title">Hints</h3>
                </div>
            </div>
            <div class="card-body">
                <p>
                    <span class="badge badge-cyan">{offer}</span> - offer name <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{source}</span> - source name <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{goal}</span> - goal name <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{status}</span> - status name <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{lead_id}</span> - internal lead ID<br>
                </p>
                <p>
                    <span class="badge badge-cyan">{click_id}</span> - source click ID <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{price}</span> - commission amount <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{price_currency_id}</span> - commission currency <br>
                </p>
                <p>
                    <span class="badge badge-cyan">{order_amount}</span> - selling order amount <br>
                </p>
            </div>
            <!-- table-responsive -->
        </div>
    </div><!-- col end -->
</div>
<?php ActiveForm::end(); ?>