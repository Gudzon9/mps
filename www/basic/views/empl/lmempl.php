<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<br>
<? if(Yii::$app->session->get('isDirector')) { ?>
<div class="panel panel-primary">
    <div class="panel-heading">Сотрудники
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
        <div class="input-group">
            <input type="text" class="form-control" id="fltemplname">
            <input type="hidden" id="fltemplid">
            <span class="input-group-btn">
                <button class="btn btn-primary refevent" type="button" >Go!</button>
            </span>
        </div>

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
            <span class="input-group-btn">
                <button class="btn btn-primary refevent" type="button">Go!</button>
            </span>
        </div>

    </div>
</div>

