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
        event_id_klient.val("");
        event_prim.val("");
        event_status.bootstrapSwitch('toggleDisabled',false);
        div_event_end.show();
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
        event_status.bootstrapSwitch('toggleDisabled',status);
        div_event_end.show();
    }

    function formOpen(mode) {
        if(mode == 'add') {
            $('#add').show();
            $('#edit').hide();
            //$("#delete").button("option", "disabled", true);
        }
        else if(mode == 'edit') {
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
                success: function(id){
                    calendar.fullCalendar('refetchEvents');
                }
            });
    }
    /* инициализируем Datetimepicker   datetimepicker*/
    event_start.datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
    event_end.datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});

    calendar.fullCalendar({
        firstDay: 1,
        header: {left: 'prev,next today', center: 'title', right: 'month,agendaWeek,agendaDay'},
        monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
        dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
        dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
        buttonText: {prev: "&nbsp;&#9668;&nbsp;", next: "&nbsp;&#9658;&nbsp;", prevYear: "&nbsp;&lt;&lt;&nbsp;", nextYear: "&nbsp;&gt;&gt;&nbsp;", today: "Сегодня", month: "Месяц", week: "Неделя", day: "День" },	
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        defaultView: 'agendaWeek', 
        droppable: true, 
        drop: function(date) {
            var view = calendar.fullCalendar('getView');
            //alert("The view's title is " + view.name);
            var EventObject = $(this).data('event');
            EventObject.start = date;   
            //alert(EventObject.start.hasTime());
            event_id.val(EventObject.id);
            event_type.val(EventObject.title);
            event_start.val(EventObject.start.format(format));
            if(date.hasTime()) {
                EventObject.end = EventObject.start.add(30,'minutes');
                event_end.val(EventObject.end.format(format));
            } else {
                event_allday.val("true");
                div_event_end.hide();
            }
            event_color.val(EventObject.color);
            event_type.css('background-color',EventObject.color);
            //console.log(EventObject.color);
            //console.log($('#event_type').css('background-color'));
            event_status.bootstrapSwitch('toggleDisabled',true);
            
            //calendar.fullCalendar('renderEvent', EventObject, true);
            formOpen('add');
            //console.log(calendar.fullCalendar( 'clientEvents' ));
        },
        eventClick: function(calEvent, jsEvent, view) { 
            event_id.val(calEvent.id);
            event_type.val(calEvent.title);
            event_start.val(calEvent.start.format(format));
            
            if (calEvent.start.hasTime()) {
                event_end.val(calEvent.end.format(format)) 
            } else {
                div_event_end.hide();
            }
            
            formOpen('edit');
        },
        eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, calEvent, jsEvent, ui, view ) {
            event_id.val(calEvent.id);
            event_type.val(calEvent.title);
            event_start.val(calEvent.start.format(format));
            event_end.val(calEvent.end.format(format)) 
            $.ajax({
                type: "POST",
                url: "external/fullcalendar/ajax.php",
                data: {
                    id: event_id.val(),
                    start: event_start.val(),
                    end: event_end.val(),
                    type: event_type.val(),
                    op: 'edit'
                },    
                success: function(id){
                    calendar.fullCalendar('refetchEvents');
                }
            });
        },
        eventResize: function(event, dayDelta, minuteDelta, allDay, revertFunc, calEvent, jsEvent, ui, view ) {
            event_id.val(calEvent.id);
            event_type.val(calEvent.title);
            event_start.val(calEvent.start.format(format));
            event_end.val(calEvent.end.format(format)) 
            $.ajax({
                type: "POST",
                url: "external/fullcalendar/ajax.php",
                data: {
                    id: event_id.val(),
                    start: event_start.val(),
                    end: event_end.val(),
                    type: event_type.val(),
                    op: 'edit'
                },
                success: function(id){
                    calendar.fullCalendar('refetchEvents');
                }
            });
        },
        eventSources: [{
            url: 'getevents',
            type: 'POST',
            data: function(){
                var flttypes = '', i=0;
                $('input[name=flttypes]:checkbox:checked').each(function(){
                    flttypes = flttypes + ((i==0)? '' : ',') + $(this).val();
                    i++;
                });
                console.log(flttypes);
                return {
                    fltempl: $('#fltemplid').val(),
                    fltklient: $('#fltklientid').val(),
                    fltstatus: $('input[name=fltstatus]:radio:checked').val(),
                    flttypes: flttypes,
                };    
            },
            error: function() {
                //alert('Ошибка соединения с источником данных!');
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
                id: 'addevent',
                class: 'btn btn-primary',
                text: 'Добавить',
                click: function() {
                /*
                    var url = 'add',
                        data = {
                            id: 0,
                            start: event_start.val(),
                            end: event_end.val(),
                            color: event_color.val(),
                            allDay: event_allday.val(),
                            type: event_type.val(),
                            id_type: event_id_type.val(),
                            klient: event_klient.val(),
                            id_klient: event_id_klient.val(),
                            prim: event_prim.val(),
                            status: event_status.val()
                        };
                    ajaxEvent(url,data);
                */    
                    calendar.fullCalendar('renderEvent', {
                            /* id: id, */
                            title: event_type.val(),
                            start: event_start.val(),
                            end: event_end.val(),
                            color: event_color.val(),
                            
                        });

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
                            status: event_status.val()
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
    })
    $( "#fltklientname" ).autocomplete({
        minLength: 2,
        source: "searchklient",
        select: function( event, ui ) {
            $( "#fltklientname" ).val( ui.item.value );
            $( "#fltklientid" ).val( ui.item.id );
            $('#fltklientname').blur();
        }
    })

});