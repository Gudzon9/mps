<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;

//$this->title = 'Cale';
$this->params['curmenu'] = 3;
$this->params['leftmenu'] = $this->render('lmcale');
?>
<div id="calendar" class="container" style="max-width:100%"></div>
<div id="dialog-form" title="Дело" style="overflow: hidden; ">
    <p class="validateTips"></p>
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="event_type" class="col-sm-2 control-label">Тип</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="event_type" name="event_type" value="" readonly>
            </div>    
            <label for="event_status" class="col-sm-2 control-label">Статус</label>
            <div class="col-sm-4">
                <input type="checkbox" class="form-control s-flip" name="event_status" id="event_status" data-size="small" data-on-color="info" data-on-text="Завершено" data-off-text="Активно" toglemenu data-label-text="Дело" />
            </div>
        </div>
        <div class="form-group">
            <label for="event_start" class="col-sm-2 control-label">Начало</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="event_start" id="event_start"/>
            </div>    
            <label for="event_end" class="col-sm-2 control-label">Конец</label>
            <div class="col-sm-4" id="div_event_end">
                <input type="text" class="form-control" name="event_end" id="event_end"/>
            </div>    
        </div>
        <div class="form-group" >
            <label for="event_klient" class="col-sm-2 control-label">Клиент</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="event_klient" id="event_klient"/>
            </div>    
        </div>
        <div class="form-group">
            <label for="event_prim" class="col-sm-2 control-label">Примечание</label>
            <div class="col-sm-10">
                <textarea rows="2" class="form-control" name="event_prim" id="event_prim"/></textarea>
            </div>    
        </div>
        <input type="hidden" name="event_id" id="event_id" value="">
        <input type="hidden" name="event_allday" id="event_allday" value="false">
        <input type="hidden" name="event_color" id="event_color" value="">
        <input type="hidden" name="event_id_klient" id="event_id_klient" value="">
        <input type="hidden" name="event_id_type" id="event_id_type" value="">
        
    </form>
</div>

<?php    
/*
$script = <<< JS
$('#calendar').fullCalendar({
    firstDay: 1,
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
    dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
    dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
    buttonText: {
        prev: "&nbsp;&#9668;&nbsp;",
        next: "&nbsp;&#9658;&nbsp;",
        prevYear: "&nbsp;&lt;&lt;&nbsp;",
        nextYear: "&nbsp;&gt;&gt;&nbsp;",
        today: "Сегодня",
        month: "Месяц",
        week: "Неделя",
        day: "День"
    },	
    navLinks: true, // can click day/week names to navigate views
    editable: true,
    eventLimit: true, // allow "more" link when too many events
    defaultView: 'agendaWeek', 
    droppable: true, 
    drop: function(date) {
        var EventObject = $(this).data('event');
        EventObject.start = date;
        $('#calendar').fullCalendar('renderEvent', EventObject, true);
   }
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);

    drop: function(date, allDay) { 
	var originalEventObject = $(this).data('eventObject');
	var copiedEventObject = $.extend({}, originalEventObject);
	copiedEventObject.start = date;
	copiedEventObject.allDay = allDay;
	$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
    }
    */    
?>