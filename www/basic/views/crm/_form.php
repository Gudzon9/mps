<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use app\models\Spratr;
use app\models\User;
use app\models\Event;
use app\models\Kagent;

/* @var $this yii\web\View */
/* @var $model app\models\Kagent */
/* @var $form yii\widgets\ActiveForm 
        $aPerson    = $model->getKagents()->getAddAtrs()->all();
        $aAdd = $aPerson[0]->getAddAtrs()->asArray()->all();
        ->dropDownList(Yii::$app->params['atypeKag'])
        <input type="hidden" class="aPerson" value='<?= json_encode($model->getKagents()->asArray()->all())?>'> 
'fieldClass' => 'app\components\ActiveField',
 *  */
$this->title = 'CRM';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 1;
function getarrsaratr($param) {
    return ArrayHelper::map(Spratr::find()->Where(['atrId'=>$param])->all(),'id','descr');
}
$ajstowns = ArrayHelper::map(Spratr::find()->Where(['atrId'=>$param])->all(),'id','lvlId');

?>

<div class="kagent-form">
    <?php 
        $id = uniqid();
        $form = ActiveForm::begin(['fieldClass' => 'app\components\ActiveField','id'=>$id, 'class'=>'kagent_form']); 
    ?>
    <input type="hidden" class="UniqID" value="<?=$id?>">
    <input type="hidden" class="Data-Key" value="<?=$model->id?>">
    <input type="hidden" class="aAtr" value='<?=json_encode(Yii::$app->params['aatr'])?>'>
    <input type="hidden" class="aAddAtr" value='<?= json_encode($model->getAddAtrs()->asArray()->all())?>'>
    <input type="hidden" class="atr" value='<?= json_encode($model)?>'>
    <input type="hidden" id="newrec" value='<?php echo ($model->isNewRecord) ? '1' : '0'; ?>'>
    <input type="hidden" id="typesev" value='<?=json_encode(Yii::$app->params['atypeEvent'])?>'>
    <input type="hidden" id="idkag" value="<?=$model->id?>">

    <div style="display: none">
        <?= $form->field($model, 'kindKagent')->hiddenInput()->label(false)->widget(MaskedInput::className(),['mask'=>'9']) ?>
    </div>
    <div class='row'>
        <div class="col-md-6">
            <div id="newandedit">
            <table>
                <tr>
                    <td class="col-md-3"><h4><?= $model->isNewRecord ? 'Новый клиент  '.(($model->kindKagent == 1) ? '(Человек)':'(Компания)') : 'Редактирование клиента ' ?></h4></td>
                    <td class="col-md-3"><?php if(!$model->isNewRecord) echo Html::Button('<span class="glyphicon glyphicon-time"></span> Дела', ['class' => 'btn-xs','id' => 'toshowev']); ?></td>
                </tr>
                <tr>
                    <td class="col-md-6" colspan="2"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <?php if($model->kindKagent == 1) {?>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'birthday')->widget(MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                    <td class="col-md-3"></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'companyId')->widget(Select2::classname(),['data'=>ArrayHelper::map(Kagent::find()->Where(['kindKagent'=>2])->orderBy(['name'=>SORT_ASC])->all(),'id','name'), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'posada')->textInput(['maxlength' => true])?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'regiKag')->widget(Select2::classname(),['data'=>getarrsaratr(7),'pluginEvents' => ['select2:opening' => 'function(event) { return false ;}'],'options' => ['placeholder' => '...']]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'townKag')->widget(Select2::classname(),['data'=>getarrsaratr(8),'pluginEvents' => ['change' => 'function(event) { $("#kagent-regikag").val(arraytowns[$(this).val()]); $("#kagent-regikag").trigger("change");}'], 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'typeKag')->widget(Select2::classname(),['data'=>getarrsaratr(1), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'statKag')->widget(Select2::classname(),['data'=>getarrsaratr(2), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'actiKag')->widget(Select2::classname(),['data'=>getarrsaratr(3), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'chanKag')->widget(Select2::classname(),['data'=>getarrsaratr(4), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'deliKag')->widget(Select2::classname(),['data'=>getarrsaratr(11), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"></td>
                </tr>
                <tr>
                    <td class="col-md-6" colspan="2">
                        <?= $form->field($model, 'prodKag')->hiddenInput()->label(false) ?>
                        <?= Html::activeLabel($model, 'prodKag') ?>
                        <?= Select2::widget([
                            'name' => 'prkag',
                            'data' => getarrsaratr(5),
                            'value' => explode(',',str_replace(['[',']'],['',''],$model->prodKag)),
                            'options' => ['placeholder' => 'Продукция ...', 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 2
                            ],
                            'pluginEvents' => [
                                'change' => 'function(event) { var selections = $(this).select2("data"); var forfld=""; $.each(selections, function (idx, obj) { forfld = forfld + ((idx!=0) ? ",[" : "[") + obj.id +"]" ; }); $("#kagent-prodkag").val(forfld);  }'
                            ],
                        ]); ?>                        
                    </td>
                </tr>
                <tr>
                    <td class="col-md-6" colspan="2">
                        <?= $form->field($model, 'tpayKag')->hiddenInput()->label(false) ?>
                        <?= Html::activeLabel($model, 'tpayKag') ?>
                        <?= Select2::widget([
                            'name' => 'tpkag',
                            'data' => getarrsaratr(9),
                            'value' => explode(',',str_replace(['[',']'],['',''],$model->tpayKag)),
                            'options' => ['placeholder' => 'Типы платежей ...', 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 2
                            ],
                            'pluginEvents' => [
                                'change' => 'function(event) { var selections = $(this).select2("data"); var forfld; $.each(selections, function (idx, obj) { forfld = forfld + ((idx==0) ? ",[" : "[") + obj.id +"]" ; }); $("#kagent-tpaykag").val(forfld); }'
                            ],
                        ]); ?>                        
                        
                    </td>
                </tr>                                
                <tr>
                    <td class="col-md-6" colspan="2">
                        <?= $form->field($model, 'grouKag')->hiddenInput()->label(false) ?>
                        <?= Html::activeLabel($model, 'grouKag') ?>
                        <?= Select2::widget([
                            'name' => 'grkag',
                            'data' => getarrsaratr(10),
                            'value' => explode(',',str_replace(['[',']'],['',''],$model->grouKag)),
                            'options' => ['placeholder' => 'Группы ...', 'multiple' => true],
                            'pluginOptions' => [
                                'tags' => true,
                                'tokenSeparators' => [',', ' '],
                                'maximumInputLength' => 2
                            ],
                            'pluginEvents' => [
                                'change' => 'function(event) { var selections = $(this).select2("data"); var forfld; $.each(selections, function (idx, obj) { forfld = forfld + ((idx==0) ? ",[" : "[") + obj.id +"]" ; }); $("#kagent-groukag").val(forfld); }'
                            ],
                        ]); ?>                        
                        
                    </td>
                </tr>                                
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'refuKag')->widget(Select2::classname(),['data'=>getarrsaratr(6), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3">
                    <?php
                        if(Yii::$app->user->identity->isDirector) {
                             echo $form->field($model, 'userId')->widget(Select2::classname(),['data'=>ArrayHelper::map(User::find()->orderBy(['fio'=>SORT_ASC])->all(),'id','fio'), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ; 
                        }
                    ?>
                    </td>
                </tr>
            </table>
            </div>
            <div id="showevents">
            <?php if(!$model->isNewRecord) { ?>
            <table>
                <tr>
                    <td><h3><?= $model->name.'    ' ?></h3></td>
                    <td><span style="margin-left: 30px; cursor: pointer" id="toedit" class="glyphicon glyphicon-pencil" title="Редактировать"></span> </td>
                    <td><span style="margin-left: 30px; cursor: pointer" id="todele" class="glyphicon glyphicon-trash" title="Удалить"></span></td>
                </tr>
            </table>
            <hr>    
            <h3><span class="glyphicon glyphicon-time"></span> Дела</h3>
            
            <div id="evcontent">
                <?= $this->render('tblevkag',['model' => $model,]) ?>
            </div>
            <table width="100%">
                <tr>
                    <td><br><button type="button" id="addev" class="btn-xs">+ Добавить дело</button> </td>                    
                </tr>
            </table>
            <?php } ?>   
            </div>
        </div>
        <div class="col-md-6 col-centered">
            <div class="AddAtr">
            </div>
            <hr>
            <div class="AddComent">
            </div>
        </div>
    </div>
    <div id="savebtn" class="form-group">
        <br>
    
        <?php
        if (!Yii::$app->request->isAjax){
            echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['id'=>'save_form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
            echo ' ';
            if($model->isNewRecord) {
                echo Html::Button('Отказ', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['crm/index']).'"']);
            } else {
                
            }    
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$aAtr = json_encode(Yii::$app->params['aatr']);
$aAddAtr = json_encode($model->getAddAtrs()->asArray()->all());
$aAddComent = json_encode($model->getAddComents()->orderBy(['comentDate'=>SORT_DESC])->asArray()->all());
$ajstowns = json_encode(ArrayHelper::map(Spratr::find()->Where(['atrId'=>8])->all(),'id','lvlId'));
$script = <<< JS
    var aAtr =  $aAtr;
    var aAddAtr = $aAddAtr;    
    var aAddComent = $aAddComent;
    var arraytowns = $ajstowns;   
    
    var newrec = $("#newrec").val();
    if(newrec == "1") {
        $("#newandedit").show();
        $("#savebtn").show();
        $("#showevents").hide();
    } else {
        $("#newandedit").hide();
        $("#savebtn").hide();
        $("#showevents").show();
    }
    $("#toedit").on('click', function(){    
        $("#newandedit").show();
        $("#savebtn").show();
        $("#showevents").hide();
    });   
    $("#toshowev").on('click', function(){    
        $("#newandedit").hide();
        $("#savebtn").hide();
        $("#showevents").show();
    });   
        
        
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
        
    $(document).off('click','.btnAddAtr').on('click','.btnAddAtr', function(){
        RenderAddAtr(-1,$(this).attr('indKey'));
    });
    $(document).off('click','.btnDelAddAtr').on('click','.btnDelAddAtr', function(){
        aAddAtr[$(this).attr('indKey')].status = (aAddAtr[$(this).attr('indKey')].status==1) ? 3 : 2;
        RenderAddAtr($(this).attr('indKey'));
    });        
        
    var maxId=0;
    for (var key in aAtr) {
        var strObj = '<div align="center" style="margin-bottom:5px">';
            strObj = strObj + '<a href="#" class="btn-xs btn-default btnAddAtr" style="font-weight: bold" indKey='+key+'>+ '+aAtr[key].atrDescr+'</a>';
            strObj = strObj + '<table width=100% class="tblAddAtr'+key+'" style="border-spacing:5px; border-collapse: separate"></table></div>';
        $('.AddAtr').append(strObj);
        for (var j in aAddAtr){
            if (aAddAtr[j].atrKod==key){
                RenderAddAtr(j);
                maxId = Math.max(maxId,aAddAtr[j].id);
            }
        }
    };
    
    function RenderAddAtr(Ind, atrKod){
        if (Ind==-1){
            maxId = maxId+1;
            Ind = maxId;
            aAddAtr[Ind] = {'id':Ind,'content':'','atrKod':atrKod,'note':'','status':1};
        }
        aAddAtr[Ind] = $.extend({status:0},aAddAtr[Ind]);
        var cInputName = aAtr[aAddAtr[Ind].atrKod].atrName+'['+aAddAtr[Ind].id+']';
        if (aAddAtr[Ind].status==2 || aAddAtr[Ind].status==3){
            $('[name="'+cInputName+'"]').parent().parent('tr').remove();
            if (aAddAtr[Ind].status==3){
                $('[name="inf_'+cInputName+'"]').remove();
            }else{
                $('[name="inf_'+cInputName+'"]').attr('value','del');
            }
        }else{
            var strObj = '<tr id="rr"><td><a href="#" class="btn-xs btn-default btnDelAddAtr" indKey='+Ind+'>x</a></td>';
            strObj = strObj + '<td><input name='+cInputName+' class="form-control kagaddpar"  type="text" value="'+aAddAtr[Ind].content+'"></td>';
            strObj = strObj + '<td><input name=note_'+cInputName+' class="form-control"  type="text" placeholder="примечание" value="'+aAddAtr[Ind].note+'"></td>';
            strObj = strObj + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aAddAtr[Ind].status==1) ? 'new' : '_')+'>';
            $('.tblAddAtr'+aAddAtr[Ind].atrKod).append(strObj);
            $('[name="'+aAtr[aAddAtr[Ind].atrKod].atrName+'['+aAddAtr[Ind].id+']"]').inputmask(aAtr[aAddAtr[Ind].atrKod].atrMask);
        }
    }
    
    $(document).off('click','.btnAddComent').on('click','.btnAddComent', function(){
        RenderAddComent(-1,$(this).attr('indKey'));
    });
    $(document).off('click','.btnDelAddComent').on('click','.btnDelAddComent', function(){
        aAddComent[$(this).attr('indKey')].status = (aAddComent[$(this).attr('indKey')].status==1) ? 3 : 2;
        RenderAddComent($(this).attr('indKey'));
    });        
    var maxCId=0;    
    var amonths = {'01':'янв','02':'фев','03':'мар','04':'апр','05':'май','06':'июн','07':'июл','08':'авг','09':'сен','10':'окт','11':'ноя','12':'дек'};
    var strComent = '<div align="center" style="margin-bottom:5px">';
        strComent = strComent + '<a href="#" class="btn-xs btn-default btnAddComent" style="font-weight: bold" >+ Коментарии</a>';
        strComent = strComent + '<table class="tblAddComent" style="width:100%; border-spacing:5px; border-collapse: separate"></table></div>';
    $('.AddComent').append(strComent);
    for (var j in aAddComent){
        RenderAddComent(j);
        maxCId = Math.max(maxCId,aAddComent[j].id);
    };
    function RenderAddComent(Ind){
        if (Ind==-1){
            maxId = maxId+1;
            Ind = maxId;
            var nDate = new Date();
            cDate = nDate.toISOString().substr(0,10);
            //cDate = cDate.substr(8,2)+'-'+ amonths[cDate.substr(5,2)]+'-'+ cDate.substr(0,4);
            aAddComent[Ind] = {'id':Ind,'comentDate':cDate,'descr':'','status':1};
            
        }
        aAddComent[Ind] = $.extend({status:0},aAddComent[Ind]);
        var cInputName = 'coment['+aAddComent[Ind].id+']';
        if (aAddComent[Ind].status==2 || aAddComent[Ind].status==3){
            $('[name="'+cInputName+'"]').parent().parent('tr').remove();
            if (aAddComent[Ind].status==3){
                $('[name="inf_'+cInputName+'"]').remove();
            }else{
                $('[name="inf_'+cInputName+'"]').attr('value','del');
            }
        }else{
            var vDate = aAddComent[Ind].comentDate.substr(8,2)+'-'+ amonths[aAddComent[Ind].comentDate.substr(5,2)]+'-'+ aAddComent[Ind].comentDate.substr(0,4);
            var strComent = '<tr id="rr"><td width="5%"><a href="#" class="btn-xs btn-default btnDelAddComent" indKey='+Ind+'>x</a></td>';
            strComent = strComent + '<td width="20%"><input name='+cInputName+' class="form-control"  type="text" value="'+aAddComent[Ind].comentDate+'" style="display: none;">'+vDate+'</td>';
            strComent = strComent + '<td width="75%"><textarea name=note_'+cInputName+' class="form-control kagaddpar"  type="text" placeholder="коментарий" >'+aAddComent[Ind].descr+'</textarea></td>';
            strComent = strComent + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aAddComent[Ind].status==1) ? 'new' : '_')+'>';
            $('.tblAddComent').append(strComent);
            //$('[name="coment['+aAddComent[Ind].id+']"]').inputmask("9999-99-99");
        }
    }
    if($('.Data-Key').val()=='') {
        $('.btnAddAtr').click();
        $('.btnAddComent').click();
    } 
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
            var cDate = curtr.data('start');
            cDate = cDate.substr(8,2)+' '+ amonths[cDate.substr(5,2)]+' '+ cDate.substr(0,4)+' '+ cDate.substr(11,5);
            var tmpdata = {
                    id: curtr.data('id'),
                    start: cDate,
                    id_type: curtr.data('idtype'),
                    prim: curtr.data('prim'),
                    status: 0
            };
        }  
         
        var cboev = '<select id="idtype" class="form-control" '+((newrec) ? "" : "disabled")+'>';
            for (var key in typesev) {
                cboev = cboev + '<option value="' + typesev[key].id + '" '+((Number(tmpdata.id_type) == Number(typesev[key].id)) ? 'selected':'')+'>' + typesev[key].type + '</option>' ; 
            } 
            cboev = cboev + '</select>'; 
            var incl = '<tr id="tmptr"><td><br><table width=70%  style="background: #FFFFF8">';
            incl = incl + '<tr><td colspan=2 style="text-align: right;"><span style="cursor: pointer" class="glyphicon glyphicon-remove"></span></td></tr>';
            incl = incl + '<tr><td style="padding: 5px" width=30%>'+cboev+'</td> <td style="padding: 5px" width=70%><textarea id="tmpprim" class="form-control" >' + tmpdata.prim + '</textarea></td></tr>' ;
            incl = incl + '<tr><td colspan=2><br></td></tr>';
            incl = incl + '<tr><td style="padding: 5px"><b>Когда :</b></td><td style="padding: 5px"><input type="text" id="tmpstart" class="form-control" value="' + tmpdata.start + '" /></td>';
            incl = incl + '<tr><td colspan=2><br></td></tr>';
            incl = incl + '<tr style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '<tr style="background: #EEE"><td style="padding-left: 10px" ><button id="saveevkag" class="btn btn-success" type="button">Сохранить</button></td>' ;
            incl = incl + '<td style="text-align: left; padding-left: 10px">'+((newrec) ? '' :'<a href="#" id="closevkag" >Закрыть</a>')+'</td></tr>' ;
            incl = incl + '<tr style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '</table><br></td></tr>';
            
            curtr.after(incl);
            //curtr.next().slideDown(2000);
            $('#tmpstart').datetimepicker({hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'dd M yy',monthNamesShort: ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'],monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'] , dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
            $('#saveevkag, #closevkag').on('click',function(){
                if($(this).attr('id')=='closevkag') tmpdata.status = 1 ;
                if(tmpdata.id == 0) {
                    tmpdata.id_type = $('#idtype').val();
                    for (var key in typesev) {
                        if(Number(tmpdata.id_type) == Number(typesev[key].id)) {
                            tmpdata.type = typesev[key].type ;
                            tmpdata.color = typesev[key].color ;
                        }
                    }
                }
                tmpdata.prim = $('#tmpprim').val();
                //alert($.datepicker.parseDate( "dd MM yy",$('#tmpstart').val(),{monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь']}));
                //tmpdata.start = $('#tmpstart').val();
                //tmpdata.start = $.datepicker.parseDate("@",$('#tmpstart').val(),{monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь']});
                var sdate = $("#tmpstart").datepicker('getDate').getTime();
                tmpdata.start = moment(sdate).format("YYYY-MM-DD HH:mm");
                var tdate = moment(tmpdata.start).add(30,'m'); 
                tmpdata.end = tdate.format("YYYY-MM-DD HH:mm");
                goajev(tmpdata);
            });
            $('.glyphicon-remove').on('click',function(){ 
                $('#tmptr').remove() ;
            });
    }
    function goajev(data) {   
         if(data.id_type == 0) {
             $("#idtype").focus(); return false;
         }
         if(data.prim == '') {
             $("#tmpprim").focus(); return false;
         }
         if(data.start == '') {
             $("#tmpstart").focus(); return false;
         }
        $('#tmptr').remove() ;
         $.ajax({
            type: "POST",
            url: "addeditev",
            data: data,    
            error:function(data){
                alert('error '+JSON.stringify(data));
            },
            success: function(data){ 
                    $('#evcontent').html(data);
                    sethandl();
            }
        });
    } 
        
    function sethandl() {    
        $( ".refevent" ).on("click",function(){
            var jcurtr = $(this);
            var curison = jcurtr.hasClass("on");
            $(".on" ).each(function(){ 
                $(this).removeClass("on").addClass("off").next().remove() ;
            });
            if(!curison && $('#tmptr').length == 0) {
                jcurtr.addClass("on");
                rendevwind(jcurtr,false);
            }    
        });
    }    
    $( "#addev" ).on("click",function(){ 
        if ($('#tmptr').length == 0) {
            rendevwind($(this).parent().parent(),true);
        }
    });  
    sethandl();    
    $("form").submit(function(){ 
        $(".kagaddpar").each(function(){ 
            if($(this).val()=="") {
                $(this).focus(); 
                return false;
            }
        });
        
    });  
        
JS;
if (Yii::$app->request->isAjax){
    $script = $script."; 
        $('#$id').on('beforeSubmit', function () {
            return false;
        });";
}
$this->registerJs($script,yii\web\View::POS_END); 
?>