<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

mihaildev\elfinder\Assets::noConflict($this);

//$this->title = 'Docs';
//    'path' => 'word',
$this->params['curmenu'] = 5;
$this->params['leftmenu'] = $this->render('lmdocs');
$filter = [
    0 => '',
    1 => 'application/doc',
    2 => 'application/xls',
    3 => 'application/pdf',
];
echo ElFinder::widget([
    'language'         => 'ru',
    'filter'           => $filter[$filestype],
    'controller'       => $cn , // вставляем название контроллера, по умолчанию равен elfinder
    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);
$script = <<< JS
var autoheight = $(window).height()*0.80;
$(".frame").css("height",autoheight);
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>

