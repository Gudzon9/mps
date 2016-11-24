jQuery(document).ready(function () {
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
    //$("#fltemplbtn").hide();
    //$("#fltklientbtn").hide();
});

