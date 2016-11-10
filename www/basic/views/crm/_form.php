<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kagent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kagent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kindKagent')->textInput() ?>

    <?= $form->field($model, 'typeKagent')->textInput() ?>

    <?= $form->field($model, 'company')->textInput() ?>

    <?= $form->field($model, 'posada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kuindActivity')->textInput() ?>

    <?= $form->field($model, 'userId')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
