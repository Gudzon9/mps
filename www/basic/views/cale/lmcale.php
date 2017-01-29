<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/*
$events = [
    ['id'=>'1','type'=>'Звонок','color'=>'#F0AD4E'],
    ['id'=>'2','type'=>'Встреча','color'=>'#5BC0DE'],
    ['id'=>'3','type'=>'Совещание','color'=>'#337AB7'],
    ['id'=>'4','type'=>'Праздник','color'=>'#5CB85C'],
];
 *     ['id'=>'overdue','name'=>'Просроченные'],

*/
$events = Yii::$app->params['atypeEvent'];
$fltstatus = [
    ['id'=>'all','name'=>'Все'],
    ['id'=>'act','name'=>'Активные'],
    ['id'=>'close','name'=>'Закрытые'],
];

?>
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
        <button class="btn btn-primary btn-block btn-sm refevent" id="fltemplbtn" type="button" >Принять</button>
    </div>
</div>
<? } ?>
<div class="panel panel-primary">
    <div class="panel-heading">Клиенты
	<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
    </div>
    <div class="panel-body" style="display: block">
        <div class="input-group">
            <input type="text" class="form-control"  id="fltklientname">
            <input type="hidden" id="fltklientid">
        </div>
        <button class="btn btn-primary btn-block btn-sm refevent" id="fltklientbtn" type="button">Принять</button>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">Дела
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: none">
                    <ul class="list-group">
                        <?php foreach($fltstatus as $fst){ ?>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="fltstatus" value="<?= $fst['id']; ?>" <?= ($fst['id']=='all') ? 'checked' :'' ?>>
                                    <?= $fst['name']; ?>
                                </label>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="list-group">
                        <?php foreach($events as $event){ ?>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="flttypes" value="<?= $event['id']; ?>" checked>
                                    <?= $event['type']; ?>
                                </label>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
        <button type="button" class="btn btn-primary btn-block btn-sm refevent">Принять</button>
    </div>

</div>

<div class="panel panel-primary">
    <div class="panel-heading">Drag&Drop
	<span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
    </div>    
    <div class="panel-body">
        <div id='wrap'>
            <div id='external-events'>
                <?php foreach($events as $event){ ?>
                <a class="btn btn-block btn-sm external-event" data-color="<?= $event['color']; ?>" data-id_type="<?= $event['id']; ?>"><?= $event['type']; ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
