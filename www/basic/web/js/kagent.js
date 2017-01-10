jQuery(document).ready(function () {
    var aData = new Array();
    var maxId = 0;
    $(document).off('click','tr[data-key]').on('click','tr[data-key]', function(){
        var grdID = $(this).parent().parent().parent().attr('id');
        var param = $('#'+grdID).exGridView('data').settings;
        var dataKey = $(this).attr('data-key');
        if (param.actionID!='choice'){
            Edit(param,grdID,dataKey,false);
        }
        else{            
            //var idDlg = $('#'+grdID).parent().parent().parent().attr('id');
            var idDlg = $('#'+grdID).parents('.ui-dialog-content').attr('id');
            var mainID = $('#'+idDlg).attr('mainId');
            var urlAction = aData[mainID].Param.URL;
            $.ajax({
                type:'POST',
                url:urlAction+'/get-model',
                data:{'id':dataKey},
                cache:false,
                success:function(data){
                    $('#'+idDlg).dialog('close');
                    $('#'+idDlg).remove();
                    maxId = maxId + 1;
                    aData[mainID].Person[maxId] = data;
                    console.log(data);
                    $.ajax({
                        type:'post',
                        url:urlAction+'/get-rel',
                        data:{'id':aData[mainID].Person[maxId].id,'rel':'AddAtrs'},
                        success:function(data){
                            aData[mainID].Person[maxId] = $.extend(aData[mainID].Person[maxId],{'AddAtr':data});
                            RenderPerson(maxId,mainID);
                        }
                    });
                }
            });            
        };
    });
    var btnNew = '[typebtn=KagentNew]';
    $(document).off('click',btnNew).on('click',btnNew, function(){
        
        var grdID = $(this).parent().find('.grid-view').attr('id');
        var param = $('#'+grdID).exGridView('data').settings;
        Edit(param,grdID,'',true);
    });

    function Edit(param, idGrd, dataKey,isNew, idParent){
        var url = param.URL + ((isNew)?'/create':'/update');  
        if (param.edtType=='Modal'){
            $.ajax({
                    type:'GET',
                    url:url, 
                    data:{'id':dataKey},
                    cache:false,
                    success:function(data){
                        var id = $(data).find('.UniqID').attr('value');
                        $('body').append('<div id="dlg_'+id+'">');
                        var $obj = $('#dlg_'+id);                        
                        $obj.append(data);
                        
                        if (isNew && $('#'+idGrd).attr('kindKagent')==1){
                            $obj.find('#kagent-kindkagent').val(1);
                        }
                        AppendAddAtr(param,data);
                        $obj.dialog({'modal':true,
                                    'width':'auto',
                                    buttons:[{
                                            id: "BtnOk",
                                            class: 'btn btn-primary',
                                            text: "OK",
                                            click:function(){
                                                saveEdit($obj,param,idGrd,dataKey,isNew,idParent);
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
                        $( ".ui-dialog .ui-dialog-content").css("overflow","hidden");
                    }
            });                     
        }else{
            //window.location.href = url+msgStr;
        }            
    };
    
    function saveEdit(dlg, options, grdID, data_key, isNew, idParent){

        var $form = dlg.find('form');
        $form.yiiActiveForm('data').submitting = true;
        $form.yiiActiveForm('validate');
        var disabled = $form.find(':input:disabled').removeAttr('disabled');
        var msg = $form.serialize();
        disabled.attr('disabled','disabled');
        var url = options.URL + (isNew?'/create':'/update?id='+data_key);
        $.ajax({
            type:'post',
            url:url,
            data:msg,
            cache:false,
            error:function(data){
                //alert(JSON.stringify(data));
            },
            success:function(data){
                dlg.dialog('close');
                dlg.remove();   
                if (grdID!=''){
                    $('#'+grdID).yiiGridView('applyFilter');
                };
            }
        });
    };   
    function AppendAddAtr(param,data){
        var id = $(data).find('.UniqID').attr('value');
        var dataKey = $(data).find('.Data-Key').attr('value');
        var aAtr = $.parseJSON($(data).find('.aAtr').attr('value'));
        //var aAddAtr = $.parseJSON($(data).find('.aAddAtr').attr('value'));

        //aData[id] = {Atr:aAtr,AddAtr:aAddAtr};
        aData[id] = {'Atr':aAtr,'Param':param,'AddAtr':{},'dataKey':dataKey};
        
        $('#'+id).on('beforeSubmit', function () {
            return false;
        });
        $(document).off('click','#'+id+' .btnAddAtr').on('click','#'+id+' .btnAddAtr', function(){
            RenderAddAtr(-1,$(this).attr('indKey'), id);
        });
        $(document).off('click','#'+id+' .btnDelAddAtr').on('click','#'+id+' .btnDelAddAtr', function(){
            aData[id].AddAtr[$(this).attr('indKey')].status = (aData[id].AddAtr[$(this).attr('indKey')].status==1) ? 3 : 2;
            RenderAddAtr($(this).attr('indKey'), 0, id);
        });         
        $('#'+id+' #kagent-kindkagent').on('change', function(){
            if ($(this).val()==1){
                $('#'+id+' .company').css('display','');
            }else{
                $('#'+id+' .company').css('display','none');
            };
        });

        $('#'+id+' #kagent-kindkagent').trigger('change');

        for (var key in aData[id].Atr) {
            var strObj = '<div align="center" style="margin-bottom:5px">';
                strObj = strObj + '<a href="#" class="btn-xs btn-default btnAddAtr" style="font-weight: bold" indKey='+key+'>+ '+aData[id].Atr[key].atrDescr+'</a>';
                strObj = strObj + '<table class="tblAddAtr'+key+'" style="border-spacing:5px; border-collapse: separate"></table></div>';
            $('#'+id+' .AddAtr').append(strObj);
        };
        $.ajax({
            type:'post',
            url:param.URL+'/get-rel',
            data:{'id':dataKey,'rel':'AddAtrs'},
            success:function(ret){
                aData[id] = $.extend(aData[id],{'AddAtr':ret});
                for (var j in aData[id].AddAtr){
                    RenderAddAtr(j,0,id);
                    maxId = Math.max(maxId,aData[id].AddAtr[j].id);
                }                    
            }
        })
        
        $.ajax({
            type:'post',
            url:param.URL+'/get-model',
            data:{'id':dataKey},
            success:function(ret){
            }
        })
        
        //Подгружаем контакты
       LoadPerson(data,id);        
       $('#'+id+'   #kagent-kindkagent').attr("disabled","disabled");
       //alert($(data).find("#kagent-kindkagent").attr('id'));
    };
    function RenderAddAtr(Ind, atrKod, id){
        if (Ind==-1){
            maxId = maxId+1;
            Ind = maxId;
            aData[id].AddAtr[Ind] = {'id':Ind,'content':'','atrKod':atrKod,'note':'','status':1};
        }
        aData[id].AddAtr[Ind] = $.extend({status:0},aData[id].AddAtr[Ind]);
        var cInputName = aData[id].Atr[aData[id].AddAtr[Ind].atrKod].atrName+'['+aData[id].AddAtr[Ind].id+']';
        if (aData[id].AddAtr[Ind].status==2 || aData[id].AddAtr[Ind].status==3){
            $('#'+id+' [name="'+cInputName+'"]').parent().parent('tr').remove();
            if (aData[id].AddAtr[Ind].status==3){
                $('#'+id+' [name="inf_'+cInputName+'"]').remove();
            }else{
                $('#'+id+' [name="inf_'+cInputName+'"]').attr('value','del');
            }
        }else{

            var strObj = '<tr id="rr"><td><a href="#" class="btn-xs btn-default btnDelAddAtr" indKey='+Ind+'>x</a></td>';
            strObj = strObj + '<td><input name='+cInputName+' class="form-control" style="height:25px" type="text" value="'+aData[id].AddAtr[Ind].content+'"></td>';
            strObj = strObj + '<td><input name=note_'+cInputName+' class="form-control" style="height:25px" type="text" placeholder="коментарий" value="'+aData[id].AddAtr[Ind].note+'"></td>';
            strObj = strObj + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aData[id].AddAtr[Ind].status==1) ? 'new' : '_')+'>';

            $('#'+id+' .tblAddAtr'+aData[id].AddAtr[Ind].atrKod).append(strObj);
            $('#'+id+' [name="'+aData[id].Atr[aData[id].AddAtr[Ind].atrKod].atrName+'['+aData[id].AddAtr[Ind].id+']"]').inputmask(aData[id].Atr[aData[id].AddAtr[Ind].atrKod].atrMask);
        }
    };
    function AddPerson(id){
        var url = aData[id].Param.URL+'/choice';
        $.ajax({
            url:url,
            type:'get',
            data:{'filter':{'kindKagent':1}},
            success:function(response){
                $('body').append('<div id="sel_'+id+'">');
                var $obj = $('#sel_'+id);   
                $obj.append(response);
                $obj.attr('mainId',id);   
                $obj.find('.grid-view').attr('kindKagent',1);
                $obj.dialog({'modal':true, 'width':'auto'});
            }
        });
    }
    function LoadPerson(data,id){
        //alert(id);
        var param = aData[id].Param;
        var dataKey = aData[id].dataKey;
        aData[id] = $.extend(aData[id],{'Person':{}});
        if ($(data).find('.aPerson').attr('class')=='aPerson' && $('#'+id+'   #kagent-kindkagent').val()=='2'){     
            $('#'+id+' .divAddPerson').remove();
            var strObj = '<div align="center" style="margin-bottom:5px" class="divAddPerson">';
                strObj = strObj + '<a href="#" class="btn-xs btn-default btnAddPerson" style="font-weight: bold">+ Контакт</a>';
                strObj = strObj + '<table class="tblAddPerson" style="border-spacing:5px; border-collapse: separate"></table></div>';
            $('#'+id+' .AddAtr').append(strObj);            
            $.ajax({
                type:'post',
                url:param.URL+'/get-rel',
                data:{'id':dataKey,'rel':'Kagents'},
                cache:false,
                success:function(data){
                    aData[id] = $.extend(aData[id],{'Person':data});
                    for (var j in aData[id].Person){
                        $.ajax({
                            type:'post',
                            url:param.URL+'/get-rel',
                            data:{'id':aData[id].Person[j].id,'rel':'AddAtrs'},
                            success:function(data){
                                aData[id].Person[j] = $.extend(aData[id].Person[j],{'AddAtr':data});
                                RenderPerson(j,id);
                                maxId = Math.max(maxId,aData[id].Person[j].id);
                            }
                        })
                    }
                }
            });
            
            $(document).off('click','#'+id+' .btnAddPerson').on('click','#'+id+' .btnAddPerson', function(){   
                AddPerson(id);
            });        
            $(document).off('click','#'+id+' .btnDelPerson').on('click','#'+id+' .btnDelPerson', function(){
                aData[id].Person[$(this).attr('indKey')].status = 2;
                RenderPerson($(this).attr('indKey'), id);
            });
            $(document).off('click','#'+id+' .btnInfPerson').on('click','#'+id+' .btnInfPerson', function(){
                Edit(aData[id].Param,'',aData[id].Person[$(this).attr('indKey')].id);
            });             
        }        
    }
    function RenderPerson(Ind, id){
        if (Ind==-1){
            maxId = maxId+1;
            Ind = maxId;
            aData[id].AddAtr[Ind] = {'id':Ind,'content':'','atrKod':atrKod,'note':'','status':1};
        }
        aData[id].Person[Ind] = $.extend({status:0},aData[id].Person[Ind]);
        var cInputName = 'Person['+aData[id].Person[Ind].id+']';
        if (aData[id].Person[Ind].status==2 || aData[id].Person[Ind].status==3){
            $('#'+id+' [name="'+cInputName+'"]').parent().parent('tr').remove();
            if (aData[id].AddAtr[Ind].status==3){
                $('#'+id+' [name="inf_'+cInputName+'"]').remove();
            }else{
                $('#'+id+' [name="inf_'+cInputName+'"]').attr('value','del');
            }
        }else{

            var strObj = '<tr id="rr"><td><a href="#" class="btn-xs btn-default btnDelPerson" indKey='+Ind+'>x</a></td>';
            strObj = strObj + '<td><a href="#" class="btn-xs btn-default btnInfPerson" indKey='+Ind+'>'+aData[id].Person[Ind].name+' '+((aData[id].Person[Ind].AddAtr[0]!=undefined) ? aData[id].Person[Ind].AddAtr[0].content : '')+'</a></td>';
            strObj = strObj + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aData[id].Person[Ind].status==1) ? 'new' : '_')+'>';

            $('#'+id+' .tblAddPerson').append(strObj);
        }
    };    
});    