jQuery(document).ready(function () {
    $(document).off('click','tr[data-key]').on('click','tr[data-key]', function(){
        var grdID = $(this).parent().parent().parent().attr('id');
        var param = $('#'+grdID).exGridView('data').settings;
        var dataKey = $(this).attr('[data-key]');
        Edit(param,grdID,dataKey,false);
    });


    function Edit(param, idGrd, dataKey,isNew){
        var url = param.URL + ((isNew)?'/create':'/update');  

        if (param.edtType=='Modal'){
            var $obj = $('<div/>').attr({name:'edt'+param.modelName+Math.random()});
            $.ajax({
                    type:'GET',
                    url:url, 
                    data:{'id':dataKey},
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
                                                methods.saveEdit($obj,param,idGrd,dataKey,isNew);
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
    };
    function saveEdit(dlg, options, grdID, data_key, isNew){

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
    };    
});    