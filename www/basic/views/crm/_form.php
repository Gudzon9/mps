<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kagent */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'CRM';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 1;
?>

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
    <?php
        
        //$aPerson    = $model->getKagents()->getAddAtrs()->all();
        //$aAdd = $aPerson[0]->getAddAtrs()->asArray()->all();
        
    ?>
    <input type="hidden" class="aPerson" value='<?= json_encode($model->getKagents()->asArray()->all())?>'>
    
    <div class='row'>
        <div class="col-md-8">
            <table>
                <tr style="vertical-align: top">
                    <td class="col-md-8" colspan="2"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr style="vertical-align: top">
                    <td class="col-md-4"><?= $form->field($model, 'kindKagent')->dropDownList(Yii::$app->params['akindKagent'])?></td>
                    <td class="col-md-4"><?= $form->field($model, 'birthday')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                </tr>
                <tr class="company" style="vertical-align: top;">
                    <td class="col-md-8"><?= $form->field($model, 'companyId')->inputTextBtn('kagents','name')?></td>
                    <td class="col-md-8"><?= $form->field($model, 'posada')->textInput(['maxlength' => true])?></td>
                </tr>
                <tr style="vertical-align: top">
                    <td class="col-md-4"><?= $form->field($model, 'typeKagent')->dropDownList(Yii::$app->params['atypeKagent'])?></td>
                    <td class="col-md-4"><?= $form->field($model, 'vidId')->textInput()?></td>
                </tr>
                <tr style="vertical-align: top">
                    <td class="col-md-4"><?= $form->field($model, 'city')->textInput(['maxlength' => true])?></td>
                    <td class="col-md-4"><?= $form->field($model, 'adr')->textInput(['maxlength' => true])?></td>
                </tr>                
                <tr style="vertical-align: top">
                    <td class="col-md-8" colspan="2"><?= $form->field($model, 'coment')->textInput(['maxlength' => true])?></td>
                </tr>                                
            </table>
        </div>
        <div class="col-md-4 col-centered AddAtr">
        </div>
    </div>
    <div class="form-group">
    <?php
        if (!Yii::$app->request->isAjax){
            echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        }
    ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$aAtr = json_encode(Yii::$app->params['aatr']);
$aAddAtr = json_encode($model->getAddAtrs()->asArray()->all());
//$addAtr = 'var avar aAtr = '.json_encode(Yii::$app->params['aatr']).'; var aAddAtr = '.json_encode($model->getAddAtrs()->asArray()->all()).'; ';
$script = <<< JS
    if (typeof aData == "undefined"){
        var aData = new Array();
    };
    if (typeof maxId == "undefined"){
        var maxId = 0;
    };
    aData['$id'] = {Atr:$aAtr,AddAtr:$aAddAtr};
    $(document).off('click','#$id .btnAddAtr').on('click','#$id .btnAddAtr', function(){
        RenderAddAtr(-1,$(this).attr('indKey'), '$id');
    });
    $(document).off('click','#$id .btnDelAddAtr').on('click','#$id .btnDelAddAtr', function(){
        aData['$id'].AddAtr[$(this).attr('indKey')].status = (aData['$id'].AddAtr[$(this).attr('indKey')].status==1) ? 3 : 2;
        RenderAddAtr($(this).attr('indKey'), 0, '$id');
    }); 
    $('#$id #kagent-kindkagent').on('change', function(){
        if ($(this).val()==1){
            $('#$id .company').css('display','');
        }else{
            $('#$id .company').css('display','none');
        };
    });
        
    $('#$id #kagent-kindkagent').trigger('change');
        
    for (var key in aData['$id'].Atr) {
        var strObj = '<div align="center" style="margin-bottom:5px">';
            strObj = strObj + '<a href="#" class="btn-xs btn-default btnAddAtr" style="font-weight: bold" indKey='+key+'>+ '+aData['$id'].Atr[key].atrDescr+'</a>';
            strObj = strObj + '<table class="tblAddAtr'+key+'" style="border-spacing:5px; border-collapse: separate"></table></div>';
        $('#$id .AddAtr').append(strObj);
        for (var j in aData['$id'].AddAtr){
            if (aData['$id'].AddAtr[j].atrKod==key){
                RenderAddAtr(j,0,'$id');
                maxId = Math.max(maxId,aData['$id'].AddAtr[j].id);
            }
        }
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
    }
JS;
if (Yii::$app->request->isAjax){
    $script = $script."; 
        $('#$id').on('beforeSubmit', function () {
            return false;
        });";
}
//$this->registerJs($script,yii\web\View::POS_END); 
?>