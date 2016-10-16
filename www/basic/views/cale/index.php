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

<?php
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
    /*
    drop: function(date, allDay) { 
	var originalEventObject = $(this).data('eventObject');
	var copiedEventObject = $.extend({}, originalEventObject);
	copiedEventObject.start = date;
	copiedEventObject.allDay = allDay;
	$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
    }
    */    
?>