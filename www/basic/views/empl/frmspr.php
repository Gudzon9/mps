<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = 'Справочник ['.Yii::$app->params['satr'][$model->atrId]['atrDescr'].']';
$this->params['curmenu'] = 2;
$this->params['cursubmenu'] = 4;
$this->params['leftmenu'] = $this->render('lmaspr');
?>
<h1><?= Html::encode($this->title) ?></h1>
<h3><?= $model->isNewRecord ? 'Новый элемент' : 'Исправление' ;?></h3>
    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'form-horizontal',
        ],
    ]); ?>
    <?= Html::activeTextInput($model, 'atrId', ['type' => 'hidden',]) ?>
    <br>
    <?= Html::activeLabel($model, 'descr') ?>
    <br>
    <?= Html::activeTextInput($model, 'descr', ['class' => 'form-control']) ?>
    <br>
    <?= Html::submitButton('Сохранить' , ['class' => 'btn btn-primary']).' ' ?>
    <?= Html::Button('Отказ', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['empl/aspr']).'"']) ?>

    <?php ActiveForm::end(); ?>
