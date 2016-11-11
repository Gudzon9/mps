<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id'=>'edtUser']); ?>
    <div class='row'>
        <div class="col-md-8">
            <table>
                <tr>
                    <td><?= $form->field($model, 'fio1')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'fio2')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'fio3')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td colspan='2'><?= $form->field($model, 'emailLogin')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td><?= $form->field($model, 'birthday')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                    <td><?= $form->field($model, 'dateEmp')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                    <td><?= $form->field($model, 'dateDis')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'9{4}-9{2}-9{2}']) ?></td>
                </tr>
                <tr>
                    <td colspan="3"><?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td><?= $form->field($model, 'tin')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'9{10}']) ?></td>
                    <td colspan="2"><?= $form->field($model, 'passport')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'a{2}\-9{6}'])?></td>
                </tr>
                <tr>
                    <td colspan="3"><?= $form->field($model, 'statusEmp')->dropDownList(Yii::$app->params['astatusEmp']) ?></td>
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

$addAtr = 'var aAtr = '.json_encode(Yii::$app->params['aatr']).'; var aAddAtr = '.json_encode($model->getAddAtr()->asArray()->all()).'; ';
$script = <<< JS
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
            strObj = strObj + '<table class="tblAddAtr'+key+'" style="border-spacing:5px; border-collapse: separate"></table></div>';
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
            strObj = strObj + '<td><input name='+cInputName+' class="form-control" style="height:25px" type="text" value='+aAddAtr[Ind].content+'></td>';
            strObj = strObj + '<td><input name=note_'+cInputName+' class="form-control" style="height:25px" type="text" placeholder="коментарий" value='+aAddAtr[Ind].note+'></td>';
            strObj = strObj + '</tr><input name=inf_'+cInputName+' type="hidden" value='+((aAddAtr[Ind].status==1) ? 'new' : '_')+'>';
            $('.tblAddAtr'+aAddAtr[Ind].atrKod).append(strObj);
            $('[name="'+aAtr[aAddAtr[Ind].atrKod].atrName+'['+aAddAtr[Ind].id+']"]').inputmask(aAtr[aAddAtr[Ind].atrKod].atrMask);
        }
    }
JS;
$script = $addAtr.$script;
if (Yii::$app->request->isAjax){
    $script = $script."; 
        $('#edtUser').on('beforeSubmit', function () {
            return false;
        });";
}
$this->registerJs($script,yii\web\View::POS_END); 
?>
