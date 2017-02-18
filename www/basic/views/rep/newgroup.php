<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\User;
use yii\widgets\ActiveForm;
/*
 * <select id="ttt"><option value="0" selected>Категория фильтра</option></select>
 */
?>
<h4>Новая группа</h4>
<form class="form-inline" role="form">
<div class="row">
    <div class="col-xs-4">
        Название <input type='text' id='groupname' name='groupname' class='form-control'>
    </div>
    <div class="col-xs-3">
        <?= Select2::widget([
            'name' => 'seldate',
            'data' => ['1'=>'Дата добавления клиента','2'=>'Дата добавления коментария'],
            'options' => ['placeholder' => 'Дата ...','id' => 'seldate'],
        ]); ?>                        
    </div>
    <div class="col-xs-5">
        От <input type='text' id='fromdate' name='fromdate' class='form-control'><input type='hidden' id='hfromdate' name='hfromdate'>
        До <input type='text' id='todate' name='todate' class='form-control'><input type='hidden' id='htodate' name='htodate'>
    </div>
</div>   
<br>
<table id="fltpar" class="table">
    <tr id="fltlinepatt" style="display: none">
        <td width="5%">
           <button type="button" class="delerow btn btn-danger">X</button>
        </td>
        <td width="25%">
            <select class="selkat form-control">
                <option value="0" selected>Категория фильтра</option>
                <?php foreach (Yii::$app->params['satr'] as $par) {  ?>
                <option value="<?= $par['atrId'] ?>"><?= $par['atrDescr'] ?></option>
                <?php } ?>
                <option value="12" >Ответственный</option>
            </select>     
        </td>
        <td width="70%">
            
        </td>
    </tr>
    <tr id="actblk">
        <td>
            <button type="button" class="addrow btn btn-primary">+</button>
        </td>
        <td>
            или &nbsp;&nbsp;&nbsp;<?= Html::button('Предварительный подбор',['id' =>'showit','class' => 'btn btn-primary']) ?>
        </td>
        <td>
            
        </td>
    </tr>    
</table>
<br>
<div class="row">
    <div class="col-xs-12">
        <div id="groupfrm">
            <div id="infofrm"></div>
            <?= Html::Button('Сохранить ', ['id' => 'btnsave' ,'class' => 'btn btn-success']) ?>
            <?= Html::Button('Продолжить ', ['id' => 'btntray' ,'class' => 'btn']) ?>
            <?= Html::a('Выход', ['index'], ['class' => 'btn btn-warning']) ?>        
        </div>
    </div>
</div>
</form>
<?php
$script = <<< JS
    var vgn='', vsd='0', vfd='', vtd='', vdata=[];   
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
    
    $('#fromdate').datepicker({firstDay: 1, dateFormat: 'dd M yy', altFormat: 'yy-mm-dd', altField: '#hfromdate',monthNamesShort: ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'],monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'] , dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
    $('#todate').datepicker({firstDay: 1, dateFormat: 'dd M yy', altFormat: 'yy-mm-dd', altField: '#htodate',monthNamesShort: ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'],monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'] , dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
        
    
    $( "#showit" ).on("click",function(){
        if(Number($('#seldate').val()) == 0 || $('#fromdate').val() == '' || $('#todate').val() == '' || $('#groupname').val() == '') return;
        vgn = $('#groupname').val();
        vsd = $('#seldate').val();
        vfd = $('#hfromdate').val();  
        vtd = $('#htodate').val();    
        vdata = [];
        $('.selpar').each(function(e){
            var tlen = $(this).val();
            if(tlen != null) {
                var tmp = $(this).parent().prev().children().val();
                vdata.push({vkat: tmp , vpar: tlen});
            }
        });
        if(vdata.length != 0) {
            actgroup('prepgroup');
        }
    });
    $( "#btnsave" ).on("click",function(){
        actgroup('newgroup');
    });    
    $( "#btntray" ).on("click",function(){
        wmode('forprep');
    });    
    $( ".addrow" ).on("click",function(){
        var crow = $(this).parent().parent();
        var pattrow = $( "#fltlinepatt" ).html();
        crow.before("<tr>"+pattrow+"</tr>");
        var sel = crow.prev().children().next().next().children();
        sel.select2({tags: true, theme: "classic"});
    });    
    $(document).on("click",".delerow",function(){ 
        $(this).parent().parent().remove();
    }); 
    var s2options_forload = {"themeCss":".select2-container--krajee","sizeCss":"","doReset":true,"doToggle":false,"doOrder":false};
    var select2_forload = {"theme":"krajee","width":"100%","language":"ru-RU"};
        
    $(document).on("change",".selkat",function(){ 
        var vkat = $(this).val();
        
        if(vkat != '0') {
            var tsel = $(this).parent().next();
            $.ajax({
                type: "POST",
                url: "prepsel2",
                data: "pkat="+vkat ,    
                success: function(data){ 
                    tsel.html(data);
                    if ($('#w0').data('select2')) { 
                        $('#w0').select2('destroy'); 
                    }
                    $.when(jQuery('#w0').select2(select2_forload)).done(initS2Loading('w0','s2options_forload'));        
                    $('#w0').attr('id','');
                }
            });
        }
        
    });    
    function actgroup(act) {
        $.ajax({
            type: "POST",
            url: act,
            data: "pgn="+vgn+"&psd="+vsd+"&pfd="+vfd+"&ptd="+vtd+"&pdata="+JSON.stringify(vdata) , 
            success: function(data){ 
                if(act == 'prepgroup') {
                    $("#infofrm").html(data);
                    wmode('forsave');
                } else {
                    location.reload();
                }    
            }
        });
    } 
    function wmode(stat) {
        if(stat == 'forsave') {
            $( "#groupfrm" ).show();
            $( "#actblk" ).hide();
            $( ".form-control" ).prop("disabled",true);   
            $( ".delerow" ).prop("disabled",true);
        } else {
            $( "#groupfrm" ).hide();
            $( "#actblk" ).show();
            $( ".form-control" ).prop("disabled",false);
            $( ".delerow" ).prop("disabled",false);
        }
    } 
    wmode('forprep');    
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>           
