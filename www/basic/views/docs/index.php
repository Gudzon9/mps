<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

mihaildev\elfinder\Assets::noConflict($this);

//$this->title = 'Docs';
$this->params['curmenu'] = 1;
$this->params['leftmenu'] = $this->render('lmdocs');

echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => $cn , // вставляем название контроллера, по умолчанию равен elfinder
    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);
$script = <<< JS
var autoheight = $(window).height()*0.80;
$(".frame").css("height",autoheight);
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>

