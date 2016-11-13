<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;

//$this->title = 'Main';
$this->params['curmenu'] = 1;
$this->params['leftmenu'] = $this->render('lmmain');
?>
<div id="listevents" class="container" style="max-width:100%"></div>
