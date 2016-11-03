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
                    <td><?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'dateEmp')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'dateDis')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td colspan="3"><?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?></td>
                </tr>
                <tr>
                    <td><?= $form->field($model, 'tin')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'9{10}']) ?></td>
                    <td colspan="2"><?= $form->field($model, 'passport')->widget(\yii\widgets\MaskedInput::className(),['mask'=>'a{2}\-9{6}','clientOptions'=>['removeMaskOnSubmit' => true,'autoUnmask'=>true]])?></td>
                </tr>
                <tr>
                    <td colspan="3"><?= $form->field($model, 'statusEmp')->dropDownList(Yii::$app->params['astatusEmp']) ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-4 col-centered">
            <?php foreach (Yii::$app->params['aatr'] as $key=>$rec){
                echo '<div align="center"><a href="#" id="'.$rec['atrName'].'" typeBtn="addAtr" class="btn-xs btn-success">Добавить '.$rec['atrDescr'].'</a></div>';
                echo '<table id="'.$rec['atrName'].'" maxID="1" class="addAtr" mask="'.$rec['atrMask'].'">';
                //echo '<tr>';
                //echo '<tr><td colspan="2" align="center"><a href="#" id="'.$rec['atrName'].'" typeBtn="addAtr" class="btn-xs btn-info">Добавить '.$rec['atrDescr'].'</a></td></tr>';
                    foreach ($model->getAddAtr($key)->all() As $item)
                    {
                        echo '<tr><td><a href="#" id="'.$rec['atrName'].'" typeBtn="delAtr" class="btn-xs btn-default" recid='.$item->id.'>x</a></td>';
                        echo '<td><input name="'.$rec['atrName'].'_'.$item->id.'" typeinput="addAtr" class="form-control" type="text" value='.$item->content.' recid='.$item->id.'></td>';
                        echo '<td><input name="note_'.$rec['atrName'].'_'.$item->id.'" class="form-control" type="text" value='.$item->note.'></td></tr>';
                        //$script = '$("[name='.$rec['atrName'].'_'.$item->id.']").inputmask("+7(999)9999999")';
                        //$this->registerJs($script,yii\web\View::POS_END); 
                    }
                echo '</table>';
            }?>
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
if (Yii::$app->request->isAjax){
$script = <<< JS
    $('#edtUser').on('beforeSubmit', function () {
        return false;
    });
JS;
$this->registerJs($script,yii\web\View::POS_END); 
}
$script = <<< JS
    $('[typeBtn="addAtr"').on('click', function(){
        atr = $(this).attr('id');
        maxId = parseInt($('table#'+atr).attr('maxID'))+1;
        $('table#'+atr).attr('maxID',maxId);
        strObj = '<tr><td><a href="#" id="'+atr+'" typeBtn="delAtr" class="btn-xs btn-default" recid="'+maxId+'">x</a></td><td><input name="'+atr+'_new_'+maxId+'" class="form-control" recid="'+maxId+'"></td><td><input name="note_'+atr+'_new_'+maxId+'" class="form-control"></td></tr>';
        $('table#'+atr).append(strObj);
        $('[name="'+atr+'_new_'+maxId+'"]').inputmask($('table#'+atr).attr('mask'));
    });
    $('[typeBtn="delAtr"').on('click', function(){
        atr = $(this).attr('id');
        recId = $(this).attr('recid');
        nameInput = $('input[recid="'+recId+'"]').attr('name');
        $('input[recid="'+recId+'"]').attr('name',atr+'_del_'+recId);
        $('input[recid="'+recId+'"]').attr('disabled','disabled');
        $('input[name="note_'+nameInput+'"]').attr('disabled','disabled');
        $(this).remove();
    });        
    $('[typeinput="addAtr"]').each(function(){
        var mask = $(this).parents('table.addAtr').attr('mask');
        if (mask!=''){
            $(this).inputmask(mask);
        }
    });
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>
