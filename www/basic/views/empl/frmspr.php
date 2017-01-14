<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Справочник ['.Yii::$app->params['satr'][$model->atrId]['atrDescr'].']';
$this->params['curmenu'] = 2;
$this->params['cursubmenu'] = 4;
$this->params['leftmenu'] = $this->render('lmaspr');
if($regions) {
    $itemsregions = ArrayHelper::map($regions,'id','descr');
} else {
    $itemsregions = NULL;
}    
/*
    <br>
    <?= Html::activeLabel($model, 'descr') ?>
    <br>
    <?= Html::activeTextInput($model, 'descr', ['class' => 'form-control']) ?>
    <br>

 */

?>
<h1><?= Html::encode($this->title) ?></h1>
<h3><?= $model->isNewRecord ? 'Новый элемент' : 'Исправление' ;?></h3>
    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'form-horizontal',
        ],
    ]); ?>
    <?= Html::activeTextInput($model, 'atrId', ['type' => 'hidden',]) ?>
<table width="100%">
    <tr>
        <td style="padding-left: 15px; padding-right: 25px;" width="50%">
            <?= $form->field($model, 'descr')->textInput(['maxlength' => true]) ?>
        </td>
        <td style="padding-left: 15px; padding-right: 25px;" width="50%">
            <?php if($model->atrId == 8 ) { ?>
            <?= $form->field($model, 'lvlId')->widget(Select2::classname(),['data'=>$itemsregions, 'options' => ['placeholder' => 'Выберите из списка'],'pluginOptions' => ['allowClear' => true]])->label('Область') ?>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>
    <?= Html::submitButton('Сохранить' , ['id' => 'tosave', 'class' => 'btn btn-primary']).' ' ?>
    <?= Html::Button('Отказ', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['empl/aspr','atrid'=>$model->atrId]).'"']) ?>
            
        </td>
        <td></td>
    </tr>
</table>
 
    <?php ActiveForm::end(); ?>
<?php
$script = <<< JS
        $('form').on('submit',function(){
   //alert($('#spratr-atrid').val()+' --- '+Number($('#spratr-lvlid').val()));         
   if(Number($('#spratr-atrid').val())==8 && Number($('#spratr-lvlid').val())==0) return false ;
        });
JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>
