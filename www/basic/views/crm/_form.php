<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use app\models\Spratr;
use app\models\User;

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
<h2><?= $model->isNewRecord ? 'Новый клиент  '.(($model->kindKagent == 1) ? '(Человек)':'(Компания)') : 'Редактирование клиента ' ?></h2>
<div class="kagent-form">
    <?php 
        $id = uniqid();
        $form = ActiveForm::begin(['fieldClass' => 'app\components\ActiveField','id'=>$id]); 
    ?>
    <input type="hidden" class="UniqID" value="<?=$id?>">
    <input type="hidden" class="Data-Key" value="<?=$model->id?>">
    <input type="hidden" class="aAtr" value='<?=json_encode(Yii::$app->params['aatr'])?>'>
    <input type="hidden" class="aAddAtr" value='<?= json_encode($model->getAddAtrs()->asArray()->all())?>'>
    <input type="hidden" class="atr" value='<?= json_encode($model)?>'>

    <div style="display: none">
        <?= $form->field($model, 'kindKagent')->hiddenInput()->label(false)->widget(MaskedInput::className(),['mask'=>'9']) ?>
    </div>
    <div class='row'>
        <div class="col-md-6">
            <table>
                <tr>
                    <td class="col-md-6" colspan="2"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <?php if($model->kindKagent == 1) {?>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'birthday')->widget(MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'posada')->textInput(['maxlength' => true])?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'regiKag')->widget(Select2::classname(),['data'=>getarrsaratr(7),'pluginEvents' => ['select2:opening' => 'function(event) { return false ;}'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'townKag')->widget(Select2::classname(),['data'=>getarrsaratr(8),'pluginEvents' => ['change' => 'function(event) { $("#kagent-regikag").val(arraytowns[$(this).val()]); $("#kagent-regikag").trigger("change");}'], 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'adr')->textInput(['maxlength' => true])?></td>
                    <td class="col-md-3"><?= $form->field($model, 'coment')->textInput(['maxlength' => true])?></td>
                </tr>                
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'typeKag')->widget(Select2::classname(),['data'=>getarrsaratr(1), 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'statKag')->widget(Select2::classname(),['data'=>getarrsaratr(2), 'pluginOptions' => ['allowClear' => true]]) ?></td>
                </tr>
                <tr>
                    <td class="col-md-3"><?= $form->field($model, 'actiKag')->widget(Select2::classname(),['data'=>getarrsaratr(3), 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3"><?= $form->field($model, 'chanKag')->widget(Select2::classname(),['data'=>getarrsaratr(4), 'pluginOptions' => ['allowClear' => true]]) ?></td>
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
                    <td class="col-md-3"><?= $form->field($model, 'refuKag')->widget(Select2::classname(),['data'=>getarrsaratr(6), 'pluginOptions' => ['allowClear' => true]]) ?></td>
                    <td class="col-md-3">
                    <?php
                        if(Yii::$app->user->identity->isDirector) {
                             echo $form->field($model, 'userId')->widget(Select2::classname(),['data'=>ArrayHelper::map(User::find()->orderBy(['fio'=>SORT_ASC])->all(),'id','fio'), 'pluginOptions' => ['allowClear' => true]]) ; 
                        }
                    ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 col-centered">
            <div class="AddAtr">
            </div>
            <hr>
            <div class="AddComent">
            </div>
        </div>
    </div>
    <div class="form-group">
        <br>
    <?php
        if (!Yii::$app->request->isAjax){
            
            echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
            echo ' ';
            echo Html::Button('Отказ', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['crm/index']).'"']);

//            echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
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
            strObj = strObj + '<td><input name='+cInputName+' class="form-control"  type="text" value="'+aAddAtr[Ind].content+'"></td>';
            strObj = strObj + '<td><input name=note_'+cInputName+' class="form-control"  type="text" placeholder="коментарий" value="'+aAddAtr[Ind].note+'"></td>';
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
            aAddComent[Ind] = {'id':Ind,'contentDate':'','descr':'','status':1};
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
            var strComent = '<tr id="rr"><td width="5%"><a href="#" class="btn-xs btn-default btnDelAddComent" indKey='+Ind+'>x</a></td>';
            strComent = strComent + '<td width="20%"><input name='+cInputName+' class="form-control"  type="text" value="'+aAddComent[Ind].comentDate+'"></td>';
            strComent = strComent + '<td width="75%"><textarea name=note_'+cInputName+' class="form-control"  type="text" placeholder="коментарий" >'+aAddComent[Ind].descr+'</textarea></td>';
            strComent = strComent + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aAddComent[Ind].status==1) ? 'new' : '_')+'>';
            $('.tblAddComent').append(strComent);
            $('[name="coment['+aAddComent[Ind].id+']"]').inputmask("9999-99-99");
        }
    }
JS;
if (Yii::$app->request->isAjax){
    $script = $script."; 
        $('#$id').on('beforeSubmit', function () {
            return false;
        });";
}
$this->registerJs($script,yii\web\View::POS_END); 
?>