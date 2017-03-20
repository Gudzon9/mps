<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->params['curmenu'] = 2;
$this->params['cursubmenu'] = 2;

function totdays($row){	$rv=0;	for($i=1;$i<32;$i++) { $dci=($i<10) ? "d0".$i : "d".$i ; $rv+=$row->$dci; }	return $rv; }

$bcdayoff="#FFDAB9";
$monts=array("01"=>"Январь","02"=>"Февраль","03"=>"Март","04"=>"Апрель","05"=>"Май","06"=>"Июнь","07"=>"Июль","08"=>"Август","09"=>"Сентябрь","10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");
$daytype=array(0=>" ",1=>"в",2=>"б",3=>"к");
$kolchek = 0;

								/*
                                                                if ($rowkt->$didx==0) {
									$style = " style='background-color:".$bcdayoff."'" ;
									$dtic = 5 ; $dvis = "";
								} else {
									$style = "" ;
									$dtic = $row->$didx ; $dvis = ($dtic == 1) ? "б" : "";
								}	
                                                                 * <form name="form" class="form-inline" action="" method="post"></form>
            <tr class="trow">
                <td></td><td></td>
                <td style="text-align:right">Итого</td>
                <?php for($i=1;$i<32;$i++) { ?>
                <td style="text-align:right"></td>	
                <?php } ?>
                <td style="text-align:right"></td>
            </tr>  	 	

                                                                 *                                                                  */
$records = count($qmonts);
$recfornew = count($newemp);
$anewemp = "";
foreach (ArrayHelper::map($newemp,'id','fio') as $key => $value) {
    $anewemp .= (($anewemp == "") ? "" : ";").$key.":".$value;
}
$daysinmonth = date("t", strtotime(substr($skt,0,4)."-".substr($skt,4,2)));

?>

    <?php $form = ActiveForm::begin(['id'=>'edtTabl']); ?>
    <input type="hidden" id="records" value="<?php echo $records;?>">
    <input type="hidden" id="recfornew" value="<?php echo $recfornew;?>">
    <input type="hidden" id="anewemp" value="<?php echo $anewemp;?>">
    <input type="hidden" id="currym" value="<?php echo $skt;?>">
    <br>
    <div class="row">
        <div class="col-md-2">
        <a id="btnrep" class="btn btn-success" href="#" style="display: none" >Первичное заполненне</a>
	</div>
        <div class="col-md-2">
        <select id="skt" class="form-control" name="skt" size="1" onchange="submit();">
            <?php foreach ($qmonts as $ym) { ?>
            <option value="<?php echo $ym['yearmont'] ;?>" <?php if ($ym['yearmont'] == $skt) {echo 'selected' ; } ?> > <?php echo $monts[substr($ym['yearmont'],4,2)]." ".substr($ym['yearmont'],0,4) ?> </option>
            <?php } ?>
        </select>
        </div>    
        <div class="col-md-2">
        <a id="btnsave" class="btn btn-success" style="display: none" href="#" > Сохранить изменения</a>
        </div>
        <div class="col-md-2">
        <button id="btncanc" class="btn" style="display: none" type="button" > Отмена </button>
        </div>
    </div>
    <br><br>
    <table border="1" width="100%">
        <thead >
            <tr>
                <th>
                    <?php if($recfornew > 0) { ?>
                    <input type="button" id="addnew" class="btn btn-block btn-primary btn-xs " title="Додати " value="+">
                    <?php } ?>
                </th>
                <th width="20%">Название</th>
                <?php for($i=1;$i<$daysinmonth+1;$i++) {
                    $idx=($i<10) ? '0'.$i : ''.$i ; $didx="d".$idx; 
                    //$currdate = substr($ym['yearmont'],0,4)."-".substr($ym['yearmont'],4,2)."-".$idx ;
                    $dow = date("w", mktime(0, 0, 0, substr($ym['yearmont'],4,2), $idx, substr($ym['yearmont'],0,4)));
                    $style=($dow==0 || $dow==6) ? " style='background-color:".$bcdayoff."'" : "";
                    //$style='';
                    echo "<th".$style.">".$idx."</th>" ;	
                } ?>
                <th>р</th>
                <th>б</th>
                <th>к</th>
            </tr>  	 	
        </thead>
        <tbody>
        <?php foreach ($query as $row) { $kolchek++; ?>    
            <tr id="<?php echo $row['id']; ?>" data-ls="<?php echo $row['ls']; ?>" data-name="<?php echo $row['name']; ?>" class="drow">
            <td>
                <input type="button" class="btn btn-block btn-xs btn-danger delthis" title="Удалить" value="x">
            </td>
            <td><?php echo $row['name']; ?></td>
            <?php for($i=1;$i<$daysinmonth+1;$i++) { 
                $idx=($i<10) ? '0'.$i : ''.$i ; $didx="d".$idx;
                $dvis = $daytype[$row[$didx]];
                $dow = date("w", mktime(0, 0, 0, substr($ym['yearmont'],4,2), $idx, substr($ym['yearmont'],0,4)));
                $style=($dow==0 || $dow==6) ? " style='background-color:".$bcdayoff."'" : "";

                echo "<td class='chtd iw-mTrigger' ".$style." >".$dvis."</td>" ;
            } ?>
            <td class="workdays" style="text-align: center; font-weight: bold"></td>
            <td class="seakdays" style="text-align: center; font-weight: bold"></td>
            <td class="senddays" style="text-align: center; font-weight: bold"></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <input type="hidden" name="kolchek" id="kolchek" value="<?php echo $kolchek;?>">	
<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
    $("th, .chtd").css("text-align","center");
    $(".chtd").css("cursor","pointer");    

    var FIRST_COLUMNS = 4;
    var bgrcolor = "#CFC"; edbgrcolor = "#EEE";
    var fchenged = false;
    var pskt = $("#skt").val();
    var idchd = 0;
    var idtbl = 0;
    var records = Number($("#records").val());
    var recfornew = Number($("#recfornew").val());
    var anewemp = $("#anewemp").val();    
    var kolchek = Number($("#kolchek").val());
    var currym = $("#currym").val();    
    if(kolchek == 0) {
        $("#btnrep").show();
    }

    var menu = [{
        name: 'рабочий',
        title: 'рабочий',
        fun: function (e) {
            e.trigger.html('');
            totalrecount();
        }
    }, {
        name: 'выходной',
        title: 'выходной',
        fun: function (e) {
            e.trigger.html('в');
            totalrecount();
         }
    }, {
        name: 'больничный',
        title: 'больничный',
        fun: function (e) {
            e.trigger.html('б');
            totalrecount();
        }
    }, {
        name: 'командировка',
        title: 'командировка',
        fun: function (e) {
            e.trigger.html('к');
            totalrecount();
         }
    }];     
    $(".chtd").contextMenu(menu);  
    if(recfornew>0) {
        newusers = anewemp.split(';');
        var nusrs = [];
        newusers.forEach(function(item, i, arr) {
            var aitem = item.split(':');
            var newitem = {
                    name: aitem[1],
                    title: aitem[1],
                    fun: function (e) {
                        actitabl(3,currym,aitem[0]);
                    }
                }
            nusrs.push(newitem);
        });
        $("#addnew").contextMenu(nusrs);  
    }    
    $(".chtd").on("change",function(){ 
        totalrecount();
    });   
        
    $(".delthis").on("click",function(){ 
        var currid = $(this).parent().parent().attr("id");
        if(confirm("Удалить из табеля ?")) {
            actitabl(4,currym,currid);
        }
    });    
    $("#btnsave").on("click",function(){ 
        var pdata = "";
        $(".drow").each(function(){
            var cl="";
            $(this).children('.chtd').each(function(td_num){ 
                var vdata, vchar = $.trim($(this).html()); 
                if(vchar == "") vdata = 0;
                if(vchar == "в") vdata = 1;
                if(vchar == "б") vdata = 2;
                if(vchar == "к") vdata = 3;
                //console.log((td_num+1)+"-"+vdata);
                cl+= ((cl=="") ? "":"_" )+(td_num+1)+"-"+vdata;
                
            });
            if(cl!="") {pdata += ((pdata=="") ? "":";" )+$(this).attr("id")+","+cl ;}
            
        });
        //console.log(pdata);
        actitabl(2,currym,pdata);
    });
    $("#btncanc").on("click",function(){ 
         location.reload();
    });    
    $("#btnrep").on("click",function(){ 
        if(kolchek==0) {
            actitabl(1,currym,0);
        }
    });
    function totalrecount(show=true) {
        $(".drow").each(function(){
            var workdays = 0, seakdays = 0, senddays = 0; 
            $(this).children('.chtd').each(function(){
                var vdata = $(this).html(); 
                if(vdata == " ") workdays = workdays + 1;
                if(vdata == "б") seakdays = seakdays + 1;
                if(vdata == "к") senddays = senddays + 1;
            });
            $(this).children('.workdays').html(workdays);
            $(this).children('.seakdays').html(seakdays);
            $(this).children('.senddays').html(senddays);
        });
        if(show) {
            $("#btnsave").show();
            $("#btncanc").show();
        }
    }    
    function actitabl(pact,pym,pdata) {   //console.log(pact+" = "+pdata);
        
        $.ajax({
            type: "POST",
            url: "actitabl",	
            data: "act="+pact+"&ym="+pym+"&data="+pdata ,
            success: function(retdata){ location.reload(); }
        });
        
    } 
    totalrecount(false)    
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>        