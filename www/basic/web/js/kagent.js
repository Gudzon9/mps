jQuery(document).ready(function () {
    var aData = new Array();
    var maxId = 0;
    $(document).off('click','tr[data-key]').on('click','tr[data-key]', function(){
        var grdID = $(this).parent().parent().parent().attr('id');
        var param = $('#'+grdID).exGridView('data').settings;
        var dataKey = $(this).attr('data-key');
        Edit(param,grdID,dataKey,false);
    });


    function Edit(param, idGrd, dataKey,isNew){
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
                        AppendAddAtr(param,data);
                        $obj.dialog({'modal':true,
                                    'width':'auto',
                                    buttons:[{
                                            id: "BtnOk",
                                            class: 'btn btn-primary',
                                            text: "OK",
                                            click:function(){
                                                saveEdit($obj,param,idGrd,dataKey,isNew);
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
            //window.location.href = url+msgStr;
        }            
    };
    function saveEdit(dlg, options, grdID, data_key, isNew){

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
                alert(JSON.stringify(data));
            },
            success:function(data){
                dlg.dialog('close');
                dlg.remove();                
                $('#'+grdID).yiiGridView('applyFilter');
            }
        });
    };   
    function AppendAddAtr(param,data){
        var id = $(data).find('.UniqID').attr('value');
        var aAtr = $.parseJSON($(data).find('.aAtr').attr('value'));
        var aAddAtr = $.parseJSON($(data).find('.aAddAtr').attr('value'));
        aData[id] = {Atr:aAtr,AddAtr:aAddAtr};
        
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
            for (var j in aData[id].AddAtr){
                if (aData[id].AddAtr[j].atrKod==key){
                    RenderAddAtr(j,0,id);
                    maxId = Math.max(maxId,aData[id].AddAtr[j].id);
                }
            }
        };
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
});    