jQuery(document).ready(function () {

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
                data: "pmonth="+curtr.data('yearmonth'),
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
                data: "pday="+curtr.data('day'),
                success: function(retdata){ //console.log(retdata);
                    curtr.removeClass("dayoff");
                    curtr.addClass("dayon");
                    curtr.children(".foldericon").html('<span class="glyphicon glyphicon-folder-open"></span>');
                    curtr.after(retdata);
                }
            });
        };
    });
});

