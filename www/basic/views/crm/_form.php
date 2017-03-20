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
 * 
<td><span style="margin-left: 30px; cursor: pointer" id="toedit" class="glyphicon glyphicon-pencil" title="Редактировать"></span> </td>
<td><span style="margin-left: 30px; cursor: pointer" id="todele" class="glyphicon glyphicon-trash" title="Удалить"></span></td>
            <h3><span class="glyphicon glyphicon-time"></span> Дела</h3>
                <tr>
                    <td class="col-md-3"><h4><?= $model->isNewRecord ? 'Новый клиент  '.(($model->kindKagent == 1) ? '(Человек)':'(Компания)') : 'Редактирование клиента ' ?></h4></td>
                    <td class="col-md-3"><?php if(!$model->isNewRecord) echo Html::Button('<span class="glyphicon glyphicon-time"></span> Дела', ['class' => 'btn-xs','id' => 'toshowev']); ?></td>
                </tr>
<button type="button" class="btn btn-primary" id="btnsave" style="display: none" >Save</button>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'birthday')->widget(MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                    <td class="col-md-3"></td>
                </tr>
 
 *  */
$this->title = 'CRM';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 1;
function getarrsaratr($param) {
    return ArrayHelper::map(Spratr::find()->Where(['atrId'=>$param])->all(),'id','descr');
}
$ajstowns = ArrayHelper::map(Spratr::find()->Where(['atrId'=>$param])->all(),'id','lvlId');

?>
<style>
    .inp-error {color: red;}
</style>
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
        <?= $form->field($model, 'enterdate')->hiddenInput() ?>
    </div>
    <div class='row'>
        <div class="col-md-6">
            <div id="showevents">
            <?php if(!$model->isNewRecord) { ?>
                <table width="100%"><tr>
                <td>        
                    <h4><?= $model->name.' ' ?></h4>
                </td>  
                <td style="text-align: right">
                    <?= Html::Button('Сохранить', ['id'=>'btnsave', 'class' => 'btn btn-primary', 'style' => 'display: none']) ?>
                </td>
                </tr>
                </table>
            <hr>    
            <div id="evcontent">
                <?= $this->render('tblevkag',['model' => $model,]) ?>
            </div>
            <table width="100%">
                <tr>
                    <td><br><button type="button" id="addev" class="btn-xs">+ Добавить дело</button> </td>                    
                </tr>
            </table>
            <hr>    
            <?php } ?>   
            </div>
            <div id="newandedit">
                <?php if($model->isNewRecord) {?>
                <h4>Новый клиент  <?= ($model->kindKagent == 1) ? '(Человек)':'(Компания)' ?></h4>
                <?php } ?>
            <table>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'typeKag')->widget(Select2::classname(),['data'=>getarrsaratr(1), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <?php if($model->kindKagent == 1) {?>
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
                    <td class="col-md-3"><?= $form->field($model, 'actiKag')->widget(Select2::classname(),['data'=>getarrsaratr(3), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3" >
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
                    <td class="col-md-3"><?= $form->field($model, 'statKag')->widget(Select2::classname(),['data'=>getarrsaratr(2), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'refuKag')->widget(Select2::classname(),['data'=>getarrsaratr(6), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'chanKag')->widget(Select2::classname(),['data'=>getarrsaratr(4), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3" >
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
                                'change' => 'function(event) { var selections = $(this).select2("data"); var forfld=""; $.each(selections, function (idx, obj) { forfld = forfld + ((idx!=0) ? ",[" : "[") + obj.id +"]" ; }); $("#kagent-tpaykag").val(forfld); }'
                            ],
                        ]); ?>                        
                        
                    </td>
                </tr>                                
                <tr>
                    <td class="col-md-3">
                    <?php
                        if(Yii::$app->user->identity->isDirector) {
                            echo $form->field($model, 'userId')->widget(Select2::classname(),['data'=>ArrayHelper::map(User::find()->orderBy(['fio'=>SORT_ASC])->all(),'id','fio'), 'options' => ['placeholder' => '...' ], 'pluginOptions' => ['allowClear' => true]]) ; 
                        } else {
                            echo $form->field($model, 'userId')->textInput(['type' => 'hidden']);
                            echo Select2::widget(['name' => 'userid', 'data'=>ArrayHelper::map(User::find()->all(),'id','fio'), 'value' =>$model->userId ,'options' => ['disabled'=>true ]]) ; 
//echo $form->field($model, 'userId')->widget(Select2::classname(),['data'=>ArrayHelper::map(User::find()->orderBy(['fio'=>SORT_ASC])->all(),'id','fio'), 'value' =>$model->userId ,'options' => ['placeholder' => '...','disabled'=>true ], 'pluginOptions' => ['allowClear' => true]]) ; 
                        }
                    ?>
                    </td>
                    <td class="col-md-3">
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
                                'change' => 'function(event) { var selections = $(this).select2("data"); var forfld=""; $.each(selections, function (idx, obj) { forfld = forfld + ((idx!=0) ? ",[" : "[") + obj.id +"]" ; }); $("#kagent-groukag").val(forfld); }'
                            ],
                        ]); ?>                        
                        
                    </td>
                </tr>                                
            </table>
            </div>
        </div>
        <div class="col-md-6 col-centered">
            <div class="AddAtr">
            </div>
            <hr>
            <table width="100%">
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'deliKag')->widget(Select2::classname(),['data'=>getarrsaratr(11), 'options' => ['placeholder' => '...'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'delitown')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'delinotd')->textInput(['maxlength' => true]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'delipers')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'deliprim')->textInput(['maxlength' => true]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'deliphon')->textInput(['maxlength' => true]) ?></td>
                </tr>
            </table>
            <hr>
            <div class="AddComent">
            </div>
        </div>
    </div>
    <div id="savebtn" class="form-group">
        <br>
        <table width="45%">
           <tr>
        <?php
        if (!Yii::$app->request->isAjax){
            echo '<td width="10%">'.Html::Button($model->isNewRecord ? 'Создать' : 'Сохранить', ['id'=>'save_form', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']).'</td>';
            //echo ' ';
            if($model->isNewRecord) {
                echo '<td width="10%">'.Html::Button('Отказ', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['crm/index']).'"']).'</td>';
            } else {
                if(Yii::$app->user->identity->isDirector) {
                    echo '<td width="10%">'.Html::Button('Отмена', ['class' => 'btn','onclick' => 'document.location.reload()']).'</td>';
                    echo '<td width="25%" style="text-align: right">'.Html::a('Удалить',['delete','id'=>$model->id], ['id'=>'btndele', 'class' => 'btn btn-warning']).'</td>' ;
                }
            }
        }
        ?>
            </tr>
        </table>
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
        $("#newandedit").show();
        $("#savebtn").show();
        $("#showevents").show();
    }
    $(document).on('change','.form-control',function(){    
        $("#btnsave").show();
    });
    /*    
    var vctrldel = false;    
    $("form").on("keyup",function(e){ 
        if(Number(e.keyCode) == 46) {
            if(vctrldel) {
                vctrldel = false;
                $("#btndele").hide();
                $("#save_form").show();
            } else {
                vctrldel = true;
                $("#btndele").show();
                $("#save_form").hide();
            }
        }	
    });
    */    
    $("#btnsave, #save_form").on('click',function(){
        $("form").submit();
    });    
    $("#btndele").on('click',function(){
        if(!confirm('Удалить клиента ?')) return false;
    });    
        
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');
    //$.extend($.inputmask.defaults, {
    //    "autoUnmask": true, "clearIncomplete": true
    //});    
    $(document).off('click','.btnAddAtr').on('click','.btnAddAtr', function(){
        RenderAddAtr(-1,$(this).attr('indKey'));
    });
    $(document).off('click','.btnDelAddAtr').on('click','.btnDelAddAtr', function(){
        var cObj = $(this).parent().next().children().val();
        if(confirm('Удалить '+cObj+' ?')) {
            aAddAtr[$(this).attr('indKey')].status = (aAddAtr[$(this).attr('indKey')].status==1) ? 3 : 2;
            RenderAddAtr($(this).attr('indKey'));
        }
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
            //var inptype = (aAtr[aAddAtr[Ind].atrKod].atrId == '1') ? 'text': ((aAtr[aAddAtr[Ind].atrKod].atrId == '2') ? 'email' : 'url' ) ;
            var strObj = '<tr id="rr"><td><a href="#" class="btn-xs btn-default btnDelAddAtr" indKey='+Ind+'>x</a></td>';
            strObj = strObj + '<td><input name='+cInputName+' class="form-control kagaddpar"  type="text" value="'+aAddAtr[Ind].content+'"></td>';
            strObj = strObj + '<td><input name=note_'+cInputName+' class="form-control"  type="text" placeholder="примечание" value="'+aAddAtr[Ind].note+'"></td>';
            strObj = strObj + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aAddAtr[Ind].status==1) ? 'new' : '_')+'>';
            $('.tblAddAtr'+aAddAtr[Ind].atrKod).append(strObj);
            
            if(aAtr[aAddAtr[Ind].atrKod].atrId == '1') {
                $('[name="'+aAtr[aAddAtr[Ind].atrKod].atrName+'['+aAddAtr[Ind].id+']"]').inputmask(aAtr[aAddAtr[Ind].atrKod].atrMask, {'onincomplete': function(){ $(this).addClass('inp-error'); }, 'oncomplete': function(){ $(this).removeClass('inp-error'); } });
            } else {
                if(aAtr[aAddAtr[Ind].atrKod].atrId == '2') {
                    $('[name="'+aAtr[aAddAtr[Ind].atrKod].atrName+'['+aAddAtr[Ind].id+']"]').on('blur',function(e){ 
                        if($(this).val().match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/)) {
                            $(this).removeClass('inp-error');
                        } else {
                            $(this).addClass('inp-error');
                        } 
                    });
                } else {
                    $('[name="'+aAtr[aAddAtr[Ind].atrKod].atrName+'['+aAddAtr[Ind].id+']"]').on('blur',function(e){ 
                        if($(this).val().match(/(^https?:\/\/)?[a-z0-9~_\-\.]+\.[a-z]{2,9}(\/|:|\?[!-~]*)?$/i)) {
                            $(this).removeClass('inp-error');
                        } else {
                            $(this).addClass('inp-error');
                        } 
                    });
        
                }    
            }   
        }
    }
    
    $(document).off('click','.btnAddComent').on('click','.btnAddComent', function(){
        RenderAddComent(-1,$(this).attr('indKey'));
    });
    $(document).off('click','.btnDelAddComent').on('click','.btnDelAddComent', function(){
        var cObj = $(this).parent().next().children().val();
        if(confirm('Удалить коментарий от '+cObj+' ?')) {
            aAddComent[$(this).attr('indKey')].status = (aAddComent[$(this).attr('indKey')].status==1) ? 3 : 2;
            RenderAddComent($(this).attr('indKey'));
        }
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
            strComent = strComent + '<td width="75%"><textarea name=note_'+cInputName+'  class="form-control kagaddpar"   placeholder="коментарий" cols="100" rows="4" >' +aAddComent[Ind].descr+'</textarea></td>';
            strComent = strComent + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aAddComent[Ind].status==1) ? 'new' : '_')+'>';
            $('.tblAddComent').append(strComent);
            //$('[name="coment['+aAddComent[Ind].id+']"]').inputmask("9999-99-99");
        }
    }
    if($('.Data-Key').val()=='') {
        $('.btnAddAtr').each(function(){
            if($(this).attr("indKey")=="1") $(this).click();
        });
            
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
            incl = incl + '<tr><td style="padding: 5px"><b>Когда :</b></td><td style="padding: 5px"><input type="text" id="tmpstart" class="form-control" value="' + tmpdata.start + '" /></td></tr>';
            incl = incl + '<tr class="blksave"><td colspan=2><br></td></tr>';
            incl = incl + '<tr class="blksave" style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '<tr class="blksave" style="background: #EEE"><td style="padding-left: 10px" ><button id="saveevkag" class="btn btn-success" type="button">Сохранить</button></td>' ;
            incl = incl + '<td style="text-align: left; padding-left: 10px">'+((newrec) ? '' :'<a href="#" id="closevkag" >Закрыть</a>')+'</td></tr>' ;
            incl = incl + '<tr class="blksave" style="background: #EEE"><td colspan=2><br></td></tr>';
            var infclblk = '<b>Результат :</b>';
            infclblk = infclblk + '<div class="radio" style="margin: 1px"><label><input type="radio" name="endstat" value="1" checked><span style="color: green">Завершено успешно</span></label></div>';
            infclblk = infclblk + '<div class="radio" style="margin: 1px"><label><input type="radio" name="endstat" value="2" ><span >Завершено </span></label></div>';
            infclblk = infclblk + '<div class="radio" style="margin: 1px"><label><input type="radio" name="endstat" value="3" ><span style="color: red">Завершено неудачно</span></label></div>';
            incl = incl + '<tr class="blkclos"><td  colspan=2 style="padding-left: 5px">'+infclblk+'</td></tr>';
            //incl = incl + '<tr><td  colspan=2 style="padding: 5px"><b>Результат :</b></td></tr>';
            //incl = incl + '<tr><td  colspan=2 style="padding: 5px"><input type="radio" name="endstat" class="form-control" value="1"><span style="color: green">Завершено успешно</span></td></tr>';
            //incl = incl + '<tr><td  colspan=2 style="padding: 5px"><input type="radio" name="endstat" class="form-control" value="2" ><span>Завершено</span></td></tr>';
            //incl = incl + '<tr><td  colspan=2 style="padding: 5px"><input type="radio" name="endstat" class="form-control" value="3" ><span style="color: red">Завершено неудачно</span></td></tr>';
            
            incl = incl + '<tr class="blkclos" style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '<tr class="blkclos" style="background: #EEE"><td style="padding-left: 10px" ><button id="closbuajax" class="btn btn-success" type="button">Завершить</button></td>' ;
            incl = incl + '<td style="text-align: left; padding-left: 10px"> или <a href="#" class="con-remove" style="color: red">  х Не завершать</a></td></tr>' ;
            incl = incl + '<tr class="blkclos" style="background: #EEE"><td colspan=2><br></td></tr>';
            incl = incl + '</table><br></td></tr>';
            
            curtr.after(incl);
            $('.blkclos').hide();
            //curtr.next().slideDown(2000);  ,
            $('#tmpstart').datetimepicker({firstDay: 1, hourGrid: 4, minuteGrid: 30, stepMinute: 30, dateFormat: 'dd M yy',monthNamesShort: ['янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек'],monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'] , dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ]});
            $('#closevkag').on('click',function(){
                $('.blksave').hide();
                $('.blkclos').show();
            });
            $('#saveevkag, #closbuajax').on('click',function(){
                if($(this).attr('id')=='closbuajax') tmpdata.status = $('input:radio[name=endstat]:checked').val() ;
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
            $('.glyphicon-remove, .con-remove').on('click',function(){ 
                $('#tmptr').remove() ;
            });
    }
    function goajev(data) {   
         if(data.id_type == 0) {
             $("#idtype").focus(); return false;
         }
        /* 
        if(data.prim == '') {
             $("#tmpprim").focus(); return false;
         }
        */
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
    function kagaddparchange(obj) {
        var currinp = obj;
        //console.log('currinp.val = '+currinp.val());
        //console.log(currinp.hasClass('inp-error'));
        if(currinp.val() == '' || currinp.hasClass('inp-error')) return;
        var catr = currinp.attr('name').substr(0,4);
        //console.log('catr = '+catr);
        //console.log('isnew = '+currinp.parent().parent().next().val());
        if(catr == 'note') return;
        if (currinp.parent().parent().next().val() == 'new') {
            var atrnum = ((catr == 'phon') ? '1': ((catr == 'emai') ? '2':'3'));
            var atrval = currinp.val();
            $.ajax({
                type: "POST",
                url: "searchaddatr",
                data: "pnum="+atrnum+"&pval="+atrval ,    
                success: function(data){
                    if(data.length > 1) {
                        alert(data);   
                    }    
                }
            });
            
        }

    }    
    $(document).on("change",".kagaddpar",function(){ 
        var currobj = $(this);
        setTimeout(function() {kagaddparchange(currobj);  }, 0);        
    });  
    sethandl();  
   /* 
   $('form').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
      }
    });
    */
    $(document).on('submit',function(e){ 
        var nobreak = true;
        $(".kagaddpar").each(function(){ 
            if($(this).val()=="" || $(this).hasClass('inp-error')) {
                e.preventDefault();
                $(this).focus(); 
                nobreak = false;
                return nobreak;
            }
        });
        return nobreak;
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