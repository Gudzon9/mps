<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Kagent;
use app\models\KagentSearch;
use app\models\Spratr;
use app\models\Ui;
//use app\components\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Delivery */
/* @var $form yii\widgets\ActiveForm */
/*
    <?= $form->field($model, 'msgatt')->fileInput() ?>

 *         <?= Html::activeFileInput($model, 'msgatt[]',['multiple' => 'multiple']) ?>        
<?= Html::activeFileInput($model, 'file[]',['multiple' => 'multiple']) ?>        

 *     'modelName' => 'Delivery',
        'edtType'=>'noModal',
        'Edt'=>'nomanual',
        'ui'=>new Ui(),         


 *  */

?>
<h2><?= $model->isNewRecord ? 'Новая рассылка ' : 'Редактирование рассылки ' ?></h2>
<div class="delivery-form">

    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data'
        ],
    ]); ?>

    <?= Html::activeTextInput($model, 'userId', ['type' => 'hidden',]) ?>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'name') ?>
        </div>  
        <div class="col-xs-3"> 
            <?= Html::activeTextInput($model, 'name', ['class' => 'form-control','readonly'=>'readonly']) ?>
        </div>  
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'fromadr') ?>
        </div>  
        <div class="col-xs-4"> 
            <?= Html::activeTextInput($model, 'fromadr', ['class' => 'form-control',]) ?>
        </div>  
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'date') ?>
        </div>  
        <div class="col-xs-2"> 
            <?= Html::activeTextInput($model, 'date', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'subject') ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeTextInput($model, 'subject', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?php if($model->isNewRecord) { ?>
            <?= Html::Button(Html::activeLabel($model, 'toadrs') , ['class' => 'btn','id'=>'goseladr']) ?>
            <?php } ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeTextArea($model, 'toadrs', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'msgcont') ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeTextArea($model, 'msgcont', ['class' => 'form-control',]) ?>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="col-xs-1">
            <?= Html::activeLabel($model, 'msgatt') ?>
        </div>  
        <div class="col-xs-11"> 
            <?= Html::activeFileInput($model, 'files[]',['multiple' => 'multiple']) ?>        
        </div>  
    </div>
    <?= Html::activeTextInput($model, 'msgerr', ['type' => 'hidden',]) ?>
    <br>
    <div class="row">
        <div class="col-xs-1">
        </div>
        <div class="col-xs-3">
            <?php if($model->isNewRecord) { ?>
            <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php } ?>
            <?= Html::Button('Отказ', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['delivery/index']).'"']); ?>
        </div>
    </div>    

    <?php ActiveForm::end(); ?>

</div>

<div id="dialog-toadr" title="Выбор адресатов" style="overflow: hidden; ">
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get']); ?>
    <?= $form->field($searchModel, 'typeKag')->label(false)->widget(Select2::classname(),['data'=>ArrayHelper::map(Spratr::find()->Where(['atrId'=>1])->all(),'id','descr'),'pluginEvents' => ['change' => 'function(e) {  $("#selkagents-filters input:last").val($(this).val());  console.log($("#selkagents-filters input:last").val()); $("#selkagents").yiiGridView("applyFilter");}']])  ?>
    <?php ActiveForm::end(); ?>                    

    <?php Pjax::begin(['enablePushState' => false, 'id' => ('pjaxKAgent'), 'timeout'=>2000]); ?>
    <?= GridView::widget([
        'id' => 'selkagents',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'name','adr','typeKag',
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>

<?php
$script = <<< JS
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');

    //$("[name='KagentSearch[typeKag]']").attr("id","KStK");    
    $("#goseladr").on("click",function(){ 
        $("#dialog-toadr").dialog('open');
    });
    function getRows()
    {
        var strvalue = "";
        $('input[name="selection[]"]:checked').each(function() {
            if(strvalue!="") {
                strvalue = strvalue + ","+this.value;
            } else {
                strvalue = this.value;
            }
        });
        //alert(strvalue);
        $.post({
            url: 'getemails',
            dataType: 'json',
            data: {keylist: strvalue},
            success: function(data) {
                var result='';
                data.forEach(function(item, i, arr) {
                    result = result +((result=='') ? '':', ')+ item.content;
                });
                
                $('#delivery-toadrs').val(result);
            }
       });
    }
    
    $("#dialog-toadr").dialog({ 
        autoOpen: false,
        resizable: true,
        draggable: false,
        height: "auto",
        width: 800,
        modal: true,
        buttons: [
            {
                id: 'add',
                class: 'btn btn-primary',
                text: 'Добавить',
                click: function() {
                    getRows();
                    $(this).dialog('close');
                }
            },
            {   
                id: 'cancel',
                class: 'btn',
                text: 'Отмена',
                click: function() { 
                        $(this).dialog('close');
                }
            },
        ]
    });

JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>        