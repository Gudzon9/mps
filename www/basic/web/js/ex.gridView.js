(function ($) {
    $.fn.exGridView = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.exGridView');
            return false;
        }
    };
    var gridData = {};

    var methods = {
        init: function (options){
            var id  = $(this).attr('id');
            var tblRow = "#"+id+" tr[data-key] td";
            if (gridData[id] === undefined) {
                gridData[id] = {};
            }            
            gridData[id] = $.extend(gridData[id], {settings: options});
            
            var btnNew = '[typebtn='+gridData[id].settings.modelName+'New]';
            $(document).off('click.exGridView',btnNew).on('click.exGridView',btnNew, function(){
                methods.Edit(gridData[id].settings, id, '', '',true);
            });
            $(tblRow).css('cursor','pointer');
            $(document).off('mouseover.exGridView', tblRow).on('mouseover.exGridView', tblRow, function () {
                var $row = $(this).parent().find('td');
                
                $row.css('box-shadow', '1px 1px 7px #888');
                $row.css('background','#EAEBF0');
                $row.css('cursor','pointer');
            });
           $(document).off('mouseout.exGridView', tblRow).on('mouseout.exGridView', tblRow, function () {
                $(this).parent().find('td').css('box-shadow', '');
                 $(this).parent().find('td').css('background', '');
            });            

            $(document).off('click.exGridView', tblRow).on('click.exGridView', tblRow, function () {
                methods.rowClick(gridData[id].settings, id, $(this));
            });             
        },
        rowClick: function(param, idGrd, row){
            var Err=false,
                msgStr='',
                msgAjax='';
            try {
                var $key = $.parseJSON(row.parent().attr('data-key'));
            }catch(e){
                Err = true;
            };
            if (Err || $.type($key)!=='object'){
                msgStr = '?id='+$key;
                msgAjax = {'id':$key};
            }else{
                $.each($key, function(key,value){
                    msgStr = msgStr + '?' + key + '=' + value;
                });
                msgAjax = $(this).parent().attr('data-key');
            }
            if (param.actionID=='choice'){
                var idDlg = aSelDlg[aSelDlg.length-1].id;
                var urlAction = aSelDlg[aSelDlg.length-1].url;
                $('#'+idDlg).dialog('close');
                $.ajax({
                    type:'GET',
                    url:urlAction+'/get-rec',
                    data:msgAjax,
                    cache:false,
                    success:function(data){
                        var rec = $.parseJSON(data);
                        var idFld = aSelDlg[aSelDlg.length-1].selField;
                        $('#'+idFld+' [type=hidden]').attr('value',msgAjax.id);
                        $('label#lbl'+idFld).text(rec.descr);
                        $('#'+aSelDlg[aSelDlg.length-1].grid).yiiGridView('applyFilter');
                        aSelDlg.splice(aSelDlg.length-1,1);
                    }
                });
            }else {
                methods.Edit(param, idGrd, msgAjax, msgStr);
            }            
        },
        Edit: function(param, idGrd, msgAjax, msgStr, isNew){
            var url = param.URL + ((isNew)?'/create':'/update');  
            
            if (param.edtType=='Modal'){               
                //$(document).find('[name=edt'+param.modelName+']'+Math.random()).remove();
                var $obj = methods.createDlg({'id':'edt'+param.modelName+Math.random()})
                $.ajax({
                        type:'GET',
                        url:url, 
                        data:msgAjax,
                        cache:false,
                        success:function(data){
                            $obj.append(data);
                            $obj.dialog({'modal':true,
                                        'width':'auto',
                                        buttons:[{
                                                id: "BtnOk",
                                                class: 'btn btn-primary',
                                                text: "OK",
                                                click:function(){
                                                    methods.saveEdit($obj,param,idGrd,msgStr,isNew);
                                                }
                                            },
                                            {
                                                id: "BtnCancel",
                                                class: "btn",
                                                text: "Отмена",
                                                click: function(){
                                                    $(this).dialog('close');
                                                    $(this).remove();
                                                }
                                            }
                                        ]
                            })
                        }
                });                     
            }else{
                window.location.href = url+msgStr;
            }            
        },
        saveEdit: function(dlg, options, grdID, data_key, isNew){

            var $form = dlg.find('form');
            $form.yiiActiveForm('data').submitting = true;
            $form.yiiActiveForm('validate');
            var disabled = $form.find(':input:disabled').removeAttr('disabled');
            var msg = $form.serialize();
            disabled.attr('disabled','disabled');
            var url = options.URL + (isNew?'/create':'/update'+data_key);
            $.ajax({
                type:'post',
                url:url,
                data:msg,
                cache:false,
                error:function(data){
                    alert(JSON.stringify(data));
                },
                success:function(data){
                    dlg.dialog('close');
                    dlg.remove();
                    $('#'+grdID).yiiGridView('applyFilter');
                }
            });
        },
        showColParam: function (options) {
            var $grid = $(this);
            var id = $(this).attr('id');
            var btnParam = '#' + id + ".grid-view [name='" + options.name+"']";
            
            $(document).off('click.exGridView', btnParam).on('click.exGridView', btnParam, function () {        
                $(document).find('[name="dlgParam"]').remove();
                var $obj = methods.createDlg({'name':'dlgParam'});
                $obj.attr('grdID',id);
                $obj.append($('<ul/>').attr({name:'listFld'}));
                var $ul = $obj.find('[name="listFld"]');                
                
                $ul.sortable();
                $ul.disableSelection();
                $('#'+id+'.grid-view .colinf').each(function(){
                    var $chk = $('<input/>').attr({class:'checkattr', type:'checkbox', name:$(this).attr('attribute'), sort:$(this).attr('sort')});
                    if ($(this).attr('visible')==1){
                        $chk.attr({'checked':'checked'});
                    }
                    var $li = $("<li></li>");
                    $li.css({'list-style-type': 'none', 'cursor':'move', 'font-size':'1.0em'});
                    $li.append($('<span/>').attr({'class':'ui-icon ui-icon-arrowthick-2-n-s'}));
                    $li.append($chk);
                    $li.append('   '+$(this).attr('label'));
                    $ul.append($li);
                });         
                $grid.append($obj);
                $obj.dialog({
                    modal:true,
                    position:{'my':'left top','at': 'left bottom','of':btnParam},
                    buttons:{
                        'OK':methods.sendColParam
                    },
                });
            });
        },
        
        createDlg: function(options){
            var $obj = $('<div/>').attr({name:options.name});          
            return $obj;
        },

        sendColParam: function (){
            var msg='',
                i=0,
                aMsg = {},
                grdID = $(this).attr('grdID');
            var param = gridData[grdID].settings;
            $('.checkattr',$(this)).each(function(){
                msg = msg + ((msg=='') ? '' : '&') + $(this).attr('name')+($(this).is(':checked')?'=on':'=off');
                i++;
                aMsg[i]={};
                aMsg[i]['attr'] = $(this).attr('name');
                aMsg[i]['val'] = ($(this).is(':checked')?'1':'0')+';'+i;
            });
            $(this).dialog('close');
            $.ajax({
                    type:'POST',
                    url:param.uiURL, 
                    data:{'modelName':param.modelName,'colInf':aMsg},
                    cache:false,
                    success:function(data){
                        //var grdData = $('#'+grdID).yiiGridView('data');
                        //alert(grdData.settings.filterUrl);
                        //$("#"+grdID+'.grid-view').load(grdData.settings.filterUrl +' .grid-view');
                        $('#'+grdID).yiiGridView('applyFilter');
                         //$("#"+id).load(window.location.href +" #"+id);
                    }
            });             
        },
        
        sendColParam2: function (options){
            var id = $(this).attr('id');
            var btnAplly = '#' + id + " [name='" + options.name+"']";
            $(document).off('click', btnAplly).on('click', btnAplly, function () {
                var msg='';
                var $dlg = $(document).find('#'+id+" [name='"+options.dlg+"']");
                var $i=0;
                var $aMsg = {};
                $('#'+id+" [name='"+options.dlg+"'] .checkattr").each(function(){
                    msg = msg + ((msg=='') ? '' : '&') + $(this).attr('name')+($(this).is(':checked')?'=on':'=off');
                    $i++;
                    $aMsg[$i]={};
                    $aMsg[$i]['attr'] = $(this).attr('name');
                    $aMsg[$i]['val'] = ($(this).is(':checked')?'1':'0')+';'+$i;
                });
                $dlg.modal('hide');
                $.ajax({
                        type:'POST',
                        url:param.uiURL, 
                        data:{'colInf':$aMsg},
                        cache:false,
                        success:function(data){
                            var urlGrid    = $("#"+id+" [data-sort]").attr('href');
                            $("#"+id).load(window.location.href +" #"+id);
                        }
                });             

            });
        },
        
        destroy: function () {
            return this.each(function () {
                $(window).unbind('.exGridView');
                $(this).removeData('exGridView');
            });
        },

    };
})(window.jQuery);
