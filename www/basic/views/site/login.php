<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;

//AppAsset::register($this);

$this->title = 'Login';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<style>
html, .shrinked {
    height: 100%;
}
body {
    height: 100%;
    min-width: 1000px;
    margin: 0;
    padding: 0;
    font-family: Arial;
    font-size: 81.25%;
    background-color: #FFF;
}	
body.shrinked {
    min-width: 0;
}
body.shrinked .mp-login-shrink {
    position: relative;
    top: 45%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    -webkit-backface-visibility: visible;
    -moz-backface-visibility: visible;
    backface-visibility: visible;
}
body.shrinked .mp-login {
    margin: 0 auto;
}
.ui-login-layout-main {
    width: 427px;
    margin: 0 auto;
}
.mp-login {
    position: relative;
    font-family: Arial,sans-serif;
    width: 410px;
    padding: 30px;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    box-shadow: 0 0 11px rgba(0,0,0,0.1);
}
.mp-logo {
    margin: 16px 0 26px;
    height: 50px;
    background: url('../img/mp-logo.png') center 0 no-repeat;
}
.mp-login, .mp-login * {
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
form {
    padding: 0;
    margin: 0;
}
.mp-input-wr {
    margin-bottom: 10px;
    position: relative;
}
.mp-input {
    margin: 0;
    width: 100%;
    border: 1px solid #dedede;
    line-height: 18px;
    padding: .8em .66em;
    color: #000;
    font-size: 15px;
    border-radius: 2px;
    -webkit-appearance: none;
    font-family: Arial,sans-serif;
}
.bigger div.c2 div.wdt, input, textarea {
    font-family: inherit;
    outline: 0;
}
.mp-input-passrec {
    position: absolute;
    right: 10px;
    top: 38%;
    top: -webkit-calc(50% - 6px);
    top: -moz-calc(50% - 6px);
    top: calc(50% - 6px);
    font-size: 12px;
    line-height: 1;
    color: #a5a5a5;
    cursor: pointer;
    z-index: 1;
    background: transparent;
}
.mp-login .mp-button-wr {
    margin-top: 20px;
}
.mp-input-wr {
    margin-bottom: 10px;
    position: relative;
}
button.common, .button-type.common {
    outline: 0;
    border: 0;
    margin: 0;
    user-select: none;
    -moz-user-select: none;
    overflow: visible;
    cursor: pointer;
    position: relative;
    display: inline-block;
    color: #fff;
    font: normal 13px/13px Arial,Tahoma,Verdana,Sans-Serif;
    letter-spacing: .03em;
    background-color: #6cc23e;
    padding: 8px 16px 7px 16px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    -webkit-box-shadow: 0 2px 0 #55a32c,0 2px 4px 0 #93a791;
    -moz-box-shadow: 0 2px 0 #55a32c,0 2px 4px 0 #93a791;
    box-shadow: 0 2px 0 #55a32c,0 2px 4px 0 #93a791;
    opacity: 1;
}
	</style>

</head>
<body  class="shrinked body-ru">
<?php $this->beginBody() ?>
    <div class="ui-login-layout-main mp-login-shrink">
	<div class='mp-login' id='mp-login'>
            <div class="mp-logo"></div>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>
        <div class="mp-input-wr">
        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'mp-login-input mp-input','placeholder'=>'Логин'])->label('') ?>
        </div>
        <div class="mp-input-wr">    
        <?= $form->field($model, 'password')->passwordInput(['class' => 'mp-login-input mp-input','placeholder'=>'Пароль'])->label('') ?>
        </div>
        <div class='mp-input-wr mp-button-wr'>
            <button type="submit"  id="mp-btn_default-login" class="common mp-btn_default green sdf-btn"><span class="button-text">Войти</span></button>
	</div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
