<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

mihaildev\elfinder\Assets::noConflict($this);

$this->params['curmenu'] = 5;
//$this->params['leftmenu'] = $this->render('lmdocs');

/*
// see MIME types in google    
// or \vendor\studio-42\elfinder\php\mime.types
$filter = [
    0 => '',
    1 => 'application',
    2 => 'application/vnd.ms-excel',
    3 => 'application/pdf',
];
 *     'filter'           => $filter[$filestype],

 */
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

