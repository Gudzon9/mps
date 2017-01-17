jQuery(document).ready(function () {
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
                    //location.reload();
                    ajaxEvflt();
                }
            });
    }
    function refeventseth() {
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
    }
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
        ]
    });
    $('#event_status').bootstrapSwitch();
    $( "#event_klient" ).autocomplete({
        minLength: 2,
        source: "searchklient",
        select: function( event, ui ) {
            $( "#event_id_klient" ).val( ui.item.id );
            $( "#event_klient" ).val( ui.item.value ).blur().parent().parent().removeClass('has-error');
        }
    });
    function ajaxEvflt() {
        var pdata = $("#evstat").data("stat");
         $.ajax({
            type: "POST",
            url: "getevwflt",
            data: "pflt="+pdata,  
            success: function(data){
                $("#evtitle").html("Дела : "+otext[pdata]);
                $("#evbody").html(data);
                init();
                refeventseth();
            }
        });
    }
    $("#evexpaire").on("click",function(){ 
        $("#evstat").data("stat","evexpaire") ; 
        ajaxEvflt();
    });
    $( "#evtoday" ).on("click",function(){
        $("#evstat").data("stat","evtoday") ; 
        ajaxEvflt();
    });
    $( "#evtomorow" ).on("click",function(){
        $("#evstat").data("stat","evtomorow") ; 
        ajaxEvflt();
    });
    $( "#evweek" ).on("click",function(){
        $("#evstat").data("stat","evweek") ; 
        ajaxEvflt();
    });
    var otext = {
            all : "Все",
            evexpaire : "Просроченные",
            evtoday : "Сегодня",
            evtomorow : "Завтра",
            evweek : "Неделя"
    };
///////////////////////////////////////////////////////////
    var img_dir = ""; 
    var sort_case_sensitive = false; 

    function _sort(a, b) {
        var a = a[0];
        var b = b[0];
        var _a = (a + '').replace(/,/, '.');
        var _b = (b + '').replace(/,/, '.');
        if (parseFloat(_a) && parseFloat(_b)) return sort_numbers(parseFloat(_a), parseFloat(_b));
        else if (!sort_case_sensitive) return sort_insensitive(a, b);
        else return sort_sensitive(a, b);
    }
    function sort_numbers(a, b) {
        return a - b;
    }
    function sort_insensitive(a, b) {
        var anew = a.toLowerCase();
        var bnew = b.toLowerCase();
        if (anew < bnew) return -1;
        if (anew > bnew) return 1;
        return 0;
    }
    function sort_sensitive(a, b) {
        if (a < b) return -1;
        if (a > b) return 1;
        return 0;
    }
    function getConcatenedTextContent(node) {
        var _result = "";
        if (node == null) {
            return _result;
        }
        var childrens = node.childNodes;
        var i = 0;
        while (i < childrens.length) {
            var child = childrens.item(i);
            switch (child.nodeType) {
                case 1: // ELEMENT_NODE
                case 5: // ENTITY_REFERENCE_NODE
                    _result += getConcatenedTextContent(child);
                    break;
                case 3: // TEXT_NODE
                case 2: // ATTRIBUTE_NODE
                case 4: // CDATA_SECTION_NODE
                    _result += child.nodeValue;
                    break;
                case 6: // ENTITY_NODE
                case 7: // PROCESSING_INSTRUCTION_NODE
                case 8: // COMMENT_NODE
                case 9: // DOCUMENT_NODE
                case 10: // DOCUMENT_TYPE_NODE
                case 11: // DOCUMENT_FRAGMENT_NODE
                case 12: // NOTATION_NODE
                // skip
                break;
            }
            i++;
        }
        return _result;
    }
    function sort(e) {
        var el = window.event ? window.event.srcElement : e.currentTarget;
        while (el.tagName.toLowerCase() != "td") el = el.parentNode;
        var a = new Array();
        var name = el.lastChild.nodeValue;
        var dad = el.parentNode;
        var table = dad.parentNode.parentNode;
        var up = table.up;
        var node, arrow, curcol;
        for (var i = 0; (node = dad.getElementsByTagName("td").item(i)); i++) {
            if (node.lastChild.nodeValue == name){
                curcol = i;
                if (node.className == "curcol"){
                    arrow = node.firstChild;
                    table.up = Number(!up);
                }else{
                    node.className = "curcol";
                    arrow = node.insertBefore(document.createElement("img"),node.firstChild);
                    table.up = 0;
                }
                arrow.src = img_dir + table.up + ".gif";
                arrow.alt = "";
            }else{
                if (node.className == "curcol"){
                    node.className = "";
                    if (node.firstChild) node.removeChild(node.firstChild);
                }
            }
        }
        var tbody = table.getElementsByTagName("tbody").item(0);
        for (var i = 0; (node = tbody.getElementsByTagName("tr").item(i)); i++) {
            a[i] = new Array();
            a[i][0] = getConcatenedTextContent(node.getElementsByTagName("td").item(curcol));
            a[i][1] = getConcatenedTextContent(node.getElementsByTagName("td").item(1));
            a[i][2] = getConcatenedTextContent(node.getElementsByTagName("td").item(0));
            a[i][3] = node;
        }
        a.sort(_sort);
        if (table.up) a.reverse();
        for (var i = 0; i < a.length; i++) {
            tbody.appendChild(a[i][3]);
        }
    }
    function init(e) { 
        if (!document.getElementsByTagName) return;

        for (var j = 0; (thead = document.getElementsByTagName("thead").item(j)); j++) {
            var node;
            for (var i = 0; (node = thead.getElementsByTagName("td").item(i)); i++) {
                if (node.addEventListener) node.addEventListener("click", sort, false);
                else if (node.attachEvent) node.attachEvent("onclick", sort);
                node.title = "Нажмите на заголовок, чтобы отсортировать колонку";
            }
            thead.parentNode.up = 0;

            if (typeof(initial_sort_id) != "undefined"){
                td_for_event = thead.getElementsByTagName("td").item(initial_sort_id);
                if (document.createEvent){
                    var evt = document.createEvent("MouseEvents");
                    evt.initMouseEvent("click", false, false, window, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, td_for_event);
                    td_for_event.dispatchEvent(evt);
                } else if (td_for_event.fireEvent) td_for_event.fireEvent("onclick");
                if (typeof(initial_sort_up) != "undefined" && initial_sort_up){
                    if (td_for_event.dispatchEvent) td_for_event.dispatchEvent(evt);
                    else if (td_for_event.fireEvent) td_for_event.fireEvent("onclick");
                }
            }
        }
    }
    /*
    var root = window.addEventListener || window.attachEvent ? window : document.addEventListener ? document : null;
    if (root){
        if (root.addEventListener) root.addEventListener("load", init, false);
        else if (root.attachEvent) root.attachEvent("onload", init);
    }
    */
   init();
   refeventseth(); 
});

