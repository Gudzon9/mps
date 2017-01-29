$(document).ready(function () {
    /*
    var typesev = JSON.parse($("#typesev").val());
    function rendevwind(curtr,newrec) {
        if(newrec) {
            var tmpdata = {
                    id: 0,
                    start: '',
                    end: '',
                    allDay: '',
                    type: '',
                    id_type: 0,
                    color: '',
                    klient: $('#kagent-name').val(),
                    id_klient: $('#idkag').val(),
                    prim: '',
                    status: 0
                };

        } else {
            var tmpdata = {
                    id: curtr.data('id'),
                    start: curtr.data('start'),
                    id_type: 0,
                    prim: curtr.data('prim'),
                    status: 0
            };
        }  
        var cboev = '<select id="idtype" class="form-control" disabled='+((newrec) ? 'false' : 'true')+'>';
            for (var key in typesev) {
                cboev = cboev + '<option value="' + typesev[key].id + '" '+((Number(tmpdata.id_type) == Number(typesev[key].id)) ? 'selected':'')+'>' + typesev[key].type + '<option>' ;
            } 
            cboev = cboev + '</select>';
            var incl = '<tr><td><br><table width=70%  style="background: #FFFFF8">';
            incl = incl + '<tr><td colspan=2 style="text-align: right;"><span style="cursor: pointer" class="glyphicon glyphicon-remove"></span></td></tr>';
            incl = incl + '<tr><td style="padding: 5px" width=30%>'+cboev+'</td> <td style="padding: 5px" width=70%><textarea id="tmpprim" class="form-control" >' + tmpdata.prim + '</textarea></td></tr>' ;
            incl = incl + '<tr><td colspan=2><br></td></tr>';
            incl = incl + '<tr><td style="padding: 5px"><b>Когда :</b></td><td style="padding: 5px"><input type="text" class="form-control" id="ev_st" value="' + tmpdata.start + '" /></td>';
            incl = incl + '<tr><td colspan=2><br></td></tr>';
            incl = incl + '<tr style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '<tr style="background: #EEE"><td style="padding-left: 10px" ><button id="saveevkag" class="btn btn-success" >Сохранить</button></td>' ;
            incl = incl + '<td style="text-align: left; padding-left: 10px">'+((newrec) ? '' :'<a href="#" id="closevkag" >Закрыть</a>')+'</td></tr>' ;
            incl = incl + '<tr style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '</table><br></td></tr>';
            
            curtr.after(incl);
            //curtr.next().slideDown(2000);
            $('#ev_st').datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'yy-mm-dd',monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
            $('#saveevkag').on('click',function(){
                goajev(tmpdata,0);
            });
            $('#closevkag').on('click',function(){
                goajev(tmpdata,1);
            });
            $('.glyphicon-remove').on('click',function(){
                $(this).closest(".refevent").click();
            });
    }
    function goajev(data,sc) {
         if(data.prim == '') {$('#tmpprim').focus(); return false;}
         if(data.start == '') {$('#tmpstart').focus(); return false;}
         if(sc == 1) data.status = 1 ;
         $.ajax({
            type: "POST",
            url: "addeditev",
            data: data,    
            error:function(data){
                alert('error '+JSON.stringify(data));
            },
            success: function(data){
                    $('#evcontent').html(data);
            }
        });
    }    
    $( ".refevent" ).on("click",function(){
        var $curtr = $(this);
        var curison = $curtr.hasClass("on");
        $(".on" ).each(function(){ 
            $(this).removeClass("on").addClass("off").next().remove() ;
        });
        if(!curison) {
            $curtr.addClass("on");
            rendevwind($curtr);
        }    
    });
    */
    $( "#clearflt" ).on("click",function(){
        $( ".panel-body .form-control").each(function(){
           $(this).val(''); 
        });
        $("form").submit();
    });    
});

