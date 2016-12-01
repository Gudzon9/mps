<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<br>
<? if(Yii::$app->user->identity->isDirector) { ?>
<div class="panel panel-primary">
    <div class="panel-heading">Сотрудники
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
        <div class="input-group">
            <input type="text" class="form-control" id="fltemplname">
            <input type="hidden" id="fltemplid">
        </div>
        <button class="btn btn-primary btn-block btn-sm refevent" id="fltemplbtn" type="button" >Go</button>
    </div>
</div>
<? } ?>
<div class="panel panel-primary">
    <div class="panel-heading">Клиенты
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
        <div class="input-group">
            <input type="text" class="form-control"  id="fltklientname">
            <input type="hidden" id="fltklientid">
        </div>
        <button class="btn btn-primary btn-block btn-sm refevent" id="fltklientbtn" type="button">Go</button>
    </div>
</div>

