<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Delivery */
/* @var $form yii\widgets\ActiveForm */
/*
    <?= $form->field($model, 'userId')->textInput() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fromadr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'toadrs')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'msgcont')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'msgatt')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'msgerr')->textInput() ?>

    <?= $form->field($model, 'msgatt')->fileInput() ?>

 *         <?= Html::activeFileInput($model, 'msgatt[]',['multiple' => 'multiple']) ?>        
<?= Html::activeFileInput($model, 'file[]',['multiple' => 'multiple']) ?>        
 */

?>

<div class="delivery-form">

    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data'
        ],
    ]); ?>

    <?= Html::activeTextInput($model, 'userId', ['type' => 'hidden',]) ?>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'name') ?>
        </div>  
        <div class="col-xs-3"> 
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control','readonly'=>'readonly']) ?>
        </div>  
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'fromadr') ?>
        </div>  
        <div class="col-xs-4"> 
            <?= Html::activeTextInput($model, 'fromadr', ['class' => 'form-control',]) ?>
        </div>  
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'date') ?>
        </div>  
        <div class="col-xs-2"> 
            <?= Html::activeTextInput($model, 'date', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'subject') ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeTextInput($model, 'subject', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            
            <?= Html::Button(Html::activeLabel($model, 'toadrs') , ['class' => 'btn']) ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeTextArea($model, 'toadrs', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'msgcont') ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeTextArea($model, 'msgcont', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'msgatt') ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeFileInput($model, 'files[]',['multiple' => 'multiple']) ?>        
        </div>  
    </div>
    <?= Html::activeTextInput($model, 'msgerr', ['type' => 'hidden',]) ?>
    <br>
    <div class="row">
        <div class="col-xs-1">
        </div>
        <div class="col-xs-3">
        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>    

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>        