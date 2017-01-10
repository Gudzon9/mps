jQuery(document).ready(function () {
    /*
    function prepdata(atype,adata) {
        var flttypes = '', i=0;
        $('input[name=flttypes]:checkbox:checked').each(function(){
            flttypes = flttypes + ((i===0)? '' : ',') + $(this).val();
            i++;
        });
        return {
            acttype: atype,
            actparam: adata,
            fltempl: $('#fltemplid').val(),
            fltklient: $('#fltklientid').val(),
            fltstatus: $('input[name=fltstatus]:radio:checked').val(),
            flttypes: flttypes
        };    
    }            

    $(document).on("click",".evmonths",function(){
        var vdate ;
        var curtr=$(this) ;
        if (curtr.hasClass("monthon")) {
            curtr.removeClass("monthon");
            curtr.addClass("monthoff");
            curtr.children(".foldericon").html('<span class="glyphicon glyphicon-folder-close"></span>');
            var ctr=curtr.next();
            while (ctr.hasClass("incldays") || ctr.hasClass("inclevents")) {ctr.addClass("fordel"); ctr=ctr.next(); } ;
            curtr.nextAll(".fordel").each(function(indx){$(this).remove() ;}) ;
        } else {	
            $.ajax({
                type: "POST",
                url: "showmonth",
                data: prepdata('groupday',curtr.data('yearmonth')), 
                success: function(retdata){ //console.log(retdata);
                    curtr.removeClass("monthoff");
                    curtr.addClass("monthon");
                    curtr.children(".foldericon").html('<span class="glyphicon glyphicon-folder-open"></span>');
                    curtr.after(retdata);
                }
            });
        };
    });
    $(document).on("click",".evdays",function(){
        var vdate ;
        var curtr=$(this) ;
        if (curtr.hasClass("dayon")) {
            curtr.removeClass("dayon");
            curtr.addClass("dayoff");
            curtr.children(".foldericon").html('<span class="glyphicon glyphicon-folder-close"></span>');
            var ctr=curtr.next();
            while (ctr.hasClass("inclevents")) {ctr.addClass("fordel"); ctr=ctr.next(); } ;
            curtr.nextAll(".fordel").each(function(indx){$(this).remove() ;}) ;
        } else {	
            $.ajax({
                type: "POST",
                url: "showday",
                data: prepdata('nogroup',curtr.data('day')), 
                success: function(retdata){ //console.log(retdata);
                    curtr.removeClass("dayoff");
                    curtr.addClass("dayon");
                    curtr.children(".foldericon").html('<span class="glyphicon glyphicon-folder-open"></span>');
                    curtr.after(retdata);
                }
            });
        };
    });
    $( ".refevent" ).on("click",function(){
             $.ajax({
                type: "POST",
                url: "fltindex",
                data: prepdata('',''), 
                success: function(retdata){
                    $("#content").html(retdata);
                }
           });
    });
    $( "#fltemplname" ).autocomplete({
        minLength: 2,
        source: "searchempl",
        select: function(event,ui) {
            $("#fltemplname").val(ui.item.value).blur();
            $("#fltemplid").val(ui.item.id);
        }
    }).on("focus",function(){
        $("#fltemplname").val("");
        $("#fltemplid").val("");
    });
    $( "#fltklientname" ).autocomplete({
        minLength: 2,
        source: "searchklient",
        select: function( event, ui ) {
            $( "#fltklientname" ).val( ui.item.value ).blur();
            $( "#fltklientid" ).val( ui.item.id );
        }
    }).on("focus",function(){
        $("#fltklientname").val("");
        $("#fltklientid").val("");
    });
    */
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');

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
        //event_klient.prop("readonly",false);
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
                    location.reload();
                }
            });
    }
    $( ".refevent" ).on("click",function(){
        var pdata = $(this).data("id");
        $.ajax({
            type: "POST",
            url: "geteventbyid",
            data: "pid="+pdata,    
            success: function(data){
                    //alert('success '+ JSON.stringify(data));
                event_id.val(data.id);
                event_start.val(data.start);
                event_end.val(data.end);
                event_allday.val(data.allday);
                event_type.val(data.type);
                event_id_type.val(data.id_type);
                event_color.val(data.color);
                event_klient.val(data.klient);
                event_id_klient.val(data.id_klient);
                event_prim.val(data.prim);
                //event_status.bootstrapSwitch('toggleDisabled',status);
                div_event_end.show();
                formOpen('edit');
            }
        });
        
    });
    /* инициализируем Datetimepicker   datetimepicker*/
    event_start.datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
    event_end.datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
    
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
    /*
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
    */
    $( "#event_klient" ).autocomplete({
        minLength: 2,
        source: "searchklient",
        select: function( event, ui ) {
            $( "#event_id_klient" ).val( ui.item.id );
            $( "#event_klient" ).val( ui.item.value ).blur().parent().parent().removeClass('has-error');
        }
    });
    function ajaxEvflt(pdata,ptext) {
         $.ajax({
            type: "POST",
            url: "getevwflt",
            data: "pflt="+pdata,  
            success: function(data){
                $("#evtitle").html("Дела : "+ptext);
                $("#evbody").html(data);
            }
        });
    }
    $("#evexpaire").on("click",function(){ 
        var pdata = "evexpaire", ptext="Просроченные";
        ajaxEvflt(pdata,ptext);
    });
    $( "#evtoday" ).on("click",function(){
        var pdata = "evtoday", ptext="Сегодня";
        ajaxEvflt(pdata,ptext);
    });
    $( "#evtomorow" ).on("click",function(){
        var pdata = "evtomorow", ptext="Завтра";
        ajaxEvflt(pdata,ptext);
    });
    $( "#evweek" ).on("click",function(){
        var pdata = "evweek", ptext="Неделя";
        ajaxEvflt(pdata,ptext);
    });





    
});

