$(document).ready(function () {

    $( ".refevent" ).on("click",function(){
        alert('Функция в разработке ...');
        /*
        $.ajax({
                type: "POST",
                url: "fltindex",
                data: prepdata('',''), 
                success: function(retdata){
                    $("#content").html(retdata);
                }
        });
        */
    });
    $( "#clearflt" ).on("click",function(){
        $( ".panel-body .form-control").each(function(){
            //alert($(this).attr('name')+' = '+$(this).val());
           $(this).val(''); 
           //alert($(this).attr('name')+' = '+$(this).val());
        });
        $( "#goflt" ).click();
    });    
/*    
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
});

