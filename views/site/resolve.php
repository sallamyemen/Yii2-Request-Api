<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Resolve Request';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="resolve-form">
    <p>Resolving request from: <strong><?= Html::encode($model->name) ?></strong></p>
    <p>Email: <?= Html::encode($model->email) ?></p>
    <p>Message: <?= Html::encode($model->message) ?></p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Resolve', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
