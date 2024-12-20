<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Submit Request';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="request-form">
    <?php $form = ActiveForm::begin(['id' => 'request-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
