$(document).ready(function() {
    var event_id = $('#event_id');
    var event_start = $('#event_start');
    var event_end = $('#event_end');
    var event_allday = $('#event_allday');
    var event_type = $('#event_type');
    var event_id_type = $('#event_id_type');
    var event_color = $('#event_color');
    var event_klient = $('#event_klient');
    var event_id_klient = $('#event_id_klient');
    var event_prim = $('#event_prim');
    var event_status = $('#event_status');
    var div_event_end = $('#div_event_end');

    var calendar = $('#calendar');
    var form = $('#dialog-form');
    var format = "YYYY-MM-DD HH:mm";

    function emptyForm() {
        event_id.val("");
        event_start.val("");
        event_end.val("");
        event_allday.val("false");
        event_type.val("");
        event_id_type.val("");
        event_color.val("");
        event_klient.val("");
        event_klient.prop("readonly",false);
        event_id_klient.val("");
        event_prim.val("");
        event_status.val("0");
        event_klient.parent().parent().removeClass('has-error');
    }
    function setForm(id,start,end,allday,type,id_type,color,klient,id_klient,prim,status) {
        event_id.val(id);
        event_start.val(start);
        event_end.val(end);
        event_allday.val(allday);
        event_type.val(type);
        event_id_type.val(id_type);
        event_color.val(color);
        event_klient.val(klient);
        event_id_klient.val(id_klient);
        event_prim.val(prim);
        //event_status.bootstrapSwitch('toggleDisabled',status);
        div_event_end.show();
    }

    function formOpen(mode) {
        if(mode === 'add') {
            $('#add').show();
            $('#edit').hide();
            //$("#delete").button("option", "disabled", true);
        }
        else if(mode === 'edit') {
            $('#edit').show();
            $('#add').hide();
            //$("#delete").button("option", "disabled", false);
        }
        form.dialog('open');
    }
    function ajaxEvent(url,data) {
            $.ajax({
                type: "POST",
                url: url,
                data: data,    
                error:function(data){
                    alert('error '+JSON.stringify(data));
                },
                success: function(id){
                    //alert('success '+ JSON.stringify(id));
                    //showFltInfo();
                    calendar.fullCalendar('refetchEvents');
                }
            });
    }
    function showFltInfo() {
        var flttypes = '', i=0;
        $('input[name=flttypes]:checkbox:checked').each(function(){
            flttypes = flttypes + ((i===0)? '' : ',') + $(this).val();
            i++;
        });
        $('#fltinfo').html($('#fltemplid').val()+$('#fltklientid').val()+$('input[name=fltstatus]:radio:checked').val()+flttypes);
    }
    $( ".refevent" ).on("click",function(){
        //showFltInfo();
	calendar.fullCalendar('refetchEvents');
    });
    /* инициализируем Datetimepicker   datetimepicker*/
    event_start.datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
    event_end.datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
/*
        buttonText: {prev: "&nbsp;&#9668;&nbsp;", next: "&nbsp;&#9658;&nbsp;", prevYear: "&nbsp;&lt;&lt;&nbsp;", nextYear: "&nbsp;&gt;&gt;&nbsp;", today: "Сегодня", month: "Месяц", week: "Неделя", day: "День" },	
 
 */
    calendar.fullCalendar({
        firstDay: 1,
        header: {left: 'prev,next today', center: 'title', right: 'agendaDay,agendaWeek,month'},
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','Июнь','Июль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
        dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
        dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
        buttonText: {prev: "<", next: ">", prevYear: "<<", nextYear: ">>", today: "Сегодня", day: "День" , week: "Неделя", month: "Месяц"},	
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        defaultView: 'agendaWeek', 
        droppable: true, 
        nowIndicator: true,
        drop: function(date) {
            //alert(date);
            var view = calendar.fullCalendar('getView');
            //alert("The view's title is " + view.name);
            var originalEventObject = $(this).data('event');
            var EventObject = $.extend({}, originalEventObject);
            EventObject.start = date;   
            //alert(EventObject.start.hasTime());
            event_id.val(0);
            event_start.val(EventObject.start.format(format));
            //alert(EventObject.start.hasTime());
            if(EventObject.start.hasTime()) {
                EventObject.end = EventObject.start.add(30,'minutes');
                event_end.val(EventObject.end.format(format));
                event_allday.val("");
                div_event_end.show();
            } else {
                event_end.val(EventObject.start.format(format));
                event_allday.val("1");
                div_event_end.hide();
            }
            event_type.val(EventObject.type);
            event_id_type.val(EventObject.id_type);
            event_color.val(EventObject.color);
            if(($( "#fltklientname" ).val() !== "") && (Number($( "#fltklientid" ).val()) !== 0)) {
                event_klient.val($( "#fltklientname" ).val());
                event_id_klient.val($( "#fltklientid" ).val());
                event_klient.prop("readonly",true);
            }
            event_status.bootstrapSwitch('state',false);
            event_status.bootstrapSwitch('disabled',true);
            formOpen('add');
            
            //event_type.css('background-color',EventObject.color);
            //$("div > .ui-dialog-titlebar").css('background-color',EventObject.color);
            //console.log(EventObject.color);
            //console.log($('#event_type').css('background-color'));
            //event_status.bootstrapSwitch('toggleDisabled',true);
            
            //calendar.fullCalendar('renderEvent', EventObject, true);
            //formOpen('add');
            //calendar.fullCalendar('removeEvents', event.id);
            //return false ;
            //console.log(calendar.fullCalendar( 'clientEvents' ));
        },
        eventReceive: function(event) {
            //alert(event._id);
            calendar.fullCalendar('removeEvents', event._id);
        },
        eventClick: function(calEvent, jsEvent, view) { 
            
            event_id.val(calEvent.id);
            event_start.val(calEvent.start.format(format));
            //event_end.val(calEvent.end.format(format)) ;
            event_allday.val(calEvent.allDay);
            event_type.val(calEvent.type);
            event_id_type.val(calEvent.id_type);
            event_color.val(calEvent.color);
            event_klient.val(calEvent.klient);
            event_id_klient.val(calEvent.id_klient);
            event_prim.val(calEvent.prim);
            
            if (calEvent.allDay==='') {
                event_end.val(calEvent.end.format(format)) ;
                div_event_end.show();
            } else {
                div_event_end.hide();
            }
            event_status.bootstrapSwitch('state',(calEvent.status!=='0'));
            event_status.bootstrapSwitch('disabled',false);
            formOpen('edit');
        },
        eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, calEvent, jsEvent, ui, view ) {
            //console.log(event);
            var url = 'editevent',
                data = {
                    id: event.id,
                    start: event.start.format(format),
                    end: event.end.format(format),
                    allDay: event.allDay,
                    type: event.type,
                    id_type: event.id_type,
                    color: event.color,
                    klient: event.klient,
                    id_klient: event.id_klient,
                    prim: event.prim,
                    status: event.status
                };
            ajaxEvent(url,data);
        },
        eventResize: function(event, dayDelta, minuteDelta, allDay, revertFunc, calEvent, jsEvent, ui, view ) {
            var url = 'editevent',
                data = {
                    id: event.id,
                    start: event.start.format(format),
                    end: event.end.format(format),
                    allDay: event.allDay,
                    type: event.type,
                    id_type: event.id_type,
                    color: event.color,
                    klient: event.klient,
                    id_klient: event.id_klient,
                    prim: event.prim,
                    status: event.status
                };
            ajaxEvent(url,data);
        },
        eventSources: [{
            url: 'getevents',
            type: 'POST',
            data: function(){
                var flttypes = '', i=0;
                $('input[name=flttypes]:checkbox:checked').each(function(){
                    flttypes = flttypes + ((i===0)? '' : ',') + $(this).val();
                    i++;
                });
                //console.log(flttypes);
                return {
                    fltempl: $('#fltemplid').val(),
                    fltklient: $('#fltklientid').val(),
                    fltstatus: $('input[name=fltstatus]:radio:checked').val(),
                    flttypes: flttypes
                };    
            },
            error: function(data) {
                alert(JSON.stringify(data));
                alert('Ошибка соединения с источником данных!');
            }
        }]

    });
    
    form.dialog({ 
        autoOpen: false,
        resizable: true,
        draggable: false,
        height: "auto",
        width: 600,
        modal: true,
        buttons: [
            {
                id: 'add',
                class: 'btn btn-primary',
                text: 'Добавить',
                click: function() {
                    if (Number(event_id_klient.val()) <= 0) {
                        event_klient.focus();
                        event_klient.parent().parent().addClass('has-error');
                        return;
                    }
                    var url = 'addevent',
                    data = {
                            id: 0,
                            start: event_start.val(),
                            end: event_end.val(),
                            allDay: event_allday.val(),
                            type: event_type.val(),
                            id_type: event_id_type.val(),
                            color: event_color.val(),
                            klient: event_klient.val(),
                            id_klient: event_id_klient.val(),
                            prim: event_prim.val(),
                            status: 0
                    };
                    //console.log(data);
                    ajaxEvent(url,data);
                    $(this).dialog('close');        
                    emptyForm();
                }
            },
            {
                id: 'edit',
                class: 'btn btn-info',
                text: 'Изменить',
                click: function() {
                    var url = 'editevent',
                        data = {
                            id: event_id.val(),
                            start: event_start.val(),
                            end: event_end.val(),
                            color: event_color.val(),
                            allDay: event_allday.val(),
                            type: event_type.val(),
                            id_type: event_id_type.val(),
                            klient: event_klient.val(),
                            id_klient: event_id_klient.val(),
                            prim: event_prim.val(),
                            status: ((event_status.bootstrapSwitch('state')) ? 1 : 0 )
                        };
                    ajaxEvent(url,data);
                    $(this).dialog('close');
                    emptyForm();
                }
            },
            {   
                id: 'cancel',
                class: 'btn',
                text: 'Отмена',
                click: function() { 
                        $(this).dialog('close');
                        emptyForm();
                }
            },
                /*
                {   id: 'delete',
                    class: 'btn btn-warning',
                    text: 'Удалить',
                    click: function() { 
                        $.ajax({
                            type: "POST",
                            url: "ajax.php",
                            data: {
                                id: event_id.val(),
                                op: 'delete'
                            },
                            success: function(id){
                                calendar.fullCalendar('removeEvents', id);
                            }
                        });
                        $(this).dialog('close');
                        emptyForm();
                    },
                    disabled: true
                }
                    allDaySlot: false,
                */
        ]
    });
    $('#event_status').bootstrapSwitch();
    $('#external-events a.external-event').each(function() {
        var ccolor = $(this).data('color'), cid_type = $(this).data('id_type');
        $(this).css({'color': '#fff', 'background-color': ccolor});
        $(this).data('event', {
            type: $.trim($(this).text()), 
            id_type: cid_type,
            color: ccolor 
	});
	$(this).draggable({
            zIndex: 999,
            revert: true, 
            revertDuration: 0 
	});
    });
    $( "#fltemplname" ).autocomplete({
        minLength: 2,
        source: "searchempl",
        select: function( event, ui ) {
            $( "#fltemplname" ).val( ui.item.value );
            $( "#fltemplid" ).val( ui.item.id );
            $('#fltemplname').blur();
        }
    });
    $( "#fltklientname" ).autocomplete({
        minLength: 2,
        source: "searchklient",
        select: function( event, ui ) {
            $( "#fltklientname" ).val( ui.item.value ).blur();
            $( "#fltklientid" ).val( ui.item.id );
            //$('#fltklientname');
        }
    });
    $( "#event_klient" ).autocomplete({
        minLength: 2,
        source: "searchklient",
        select: function( event, ui ) {
            $( "#event_id_klient" ).val( ui.item.id );
            $( "#event_klient" ).val( ui.item.value ).blur().parent().parent().removeClass('has-error');
            /*
            $( "#event_klient" ).val( ui.item.value );
            $('#event_klient').blur();
            $('#event_klient').parent().parent().removeClass('has-error');
            */
        }
    });
    /*
    $( "#listevents" ).fullCalendar({
        firstDay: 1,
        header: {left: '', center: 'title', right: ''},
        monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
        dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
        dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
        buttonText: {prev: "<", next: ">", prevYear: "<<", nextYear: ">>", today: "Сегодня", month: "Месяц", week: "Неделя", day: "День" },	
        navLinks: false, // can click day/week names to navigate views
        eventLimit: true, // allow "more" link when too many events
        defaultView: 'agendaDay', 
        nowIndicator: true,
        eventSources: [{
            url: 'getevents',
            type: 'POST',
            data: function(){
                var flttypes = '', i=0;
                $('input[name=flttypes]:checkbox:checked').each(function(){
                    flttypes = flttypes + ((i===0)? '' : ',') + $(this).val();
                    i++;
                });
                //console.log(flttypes);
                return {
                    fltempl: $('#fltemplid').val(),
                    fltklient: $('#fltklientid').val(),
                    fltstatus: $('input[name=fltstatus]:radio:checked').val(),
                    flttypes: flttypes
                };    
            },
            error: function(data) {
                alert(JSON.stringify(data));
                alert('Ошибка соединения с источником данных!');
            }
        }]

    });
    */
});

