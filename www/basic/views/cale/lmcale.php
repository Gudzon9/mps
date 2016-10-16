<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>
<div class="panel panel-primary">
    <div class="panel-heading">Сотрудники
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>

    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Клиенты
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
        <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>

    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Дела
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios1">
                                    Все
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios1">
                                    Активные
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios1">
                                    Просроченные
                                </label>
                            </div>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Звонок
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Встреча
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Совещание
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Праздник
                                </label>
                            </div>
                        </li>
                    </ul>
        <button type="button" class="btn btn-primary btn-block btn-sm">Go!</button>
    </div>

</div>

<div class="panel panel-primary">
    <div class="panel-heading">Drag&Drop
	<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
    </div>    
    <div class="panel-body">
        <div id='wrap'>
            <div id='external-events'>
                <a class="btn btn-warning btn-block btn-sm external-event" data-color="#F0AD4E">Звонок</a>
                <a class="btn btn-info btn-block btn-sm external-event" data-color="#5BC0DE">Встреча</a>
                <a class="btn btn-primary btn-block btn-sm external-event" data-color="#337AB7">Совещание</a>
                <a class="btn btn-success btn-block btn-sm external-event" data-color="#5CB85C">Праздник</a>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
  $( function() {
    $( "input[type='radio']" ).checkboxradio();
  } );
JS;
//$this->registerJs($script, yii\web\View::POS_READY);</div><div class="panel-footer text-center">
/*
                <div class='external-event'>Встреча</div>
                <div class='external-event'>Совещание</div>
                <div class='external-event'>Праздник</div>
#external-events {
	float: left;
	width: 150px;
	padding: 0 10px;
	border: 1px solid #ccc;
	background: #eee;
	text-align: left;
}
.external-event { 
	margin: 10px 0;
	padding: 2px 4px;
	background: #3366CC;
	color: #fff;
	font-size: .85em;
	cursor: pointer;
}
 * 
 */
?>