<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Kagent;
use app\models\KagentSearch;
use app\models\Spratr;
//use app\models\Ui;
//use app\components\GridView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

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

 *  */

?>
<div class="delivery-form">
    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data'
        ],
    ]); ?>
    <?= Html::activeTextInput($model, 'userId', ['type' => 'hidden',]) ?>
    <div class="row">
        <div class="col-xs-6">
            <h3><?= $model->isNewRecord ? 'Новая рассылка ' : 'Просмотр рассылки ' ?></h3>
        </div>
        <div class="col-xs-6">
            <?php if($model->isNewRecord) { ?>
            <?= Html::Button(Html::activeLabel($model, 'toadrs') , ['class' => 'btn btn-sm btn-primary' ,'id'=>'goseladr']) ?>
            <?= Html::Button('Очистить список' , ['class' => 'btn btn-sm' ,'id'=>'goclradr']) ?>
            <?php } ?>
            
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <table width="100%">
                <tr>
                    <td width="20%"><?= Html::activeLabel($model, 'name') ?></td>
                    <td width="80%"><?= Html::activeTextInput($model, 'name', ['class' => 'form-control','readonly'=>'readonly']) ?></td>
                </tr>
                <tr>
                    <td><?= Html::activeLabel($model, 'fromadr') ?></td>
                    <td><table witdth="100%"><tr>
                    <td>
                    <?php if($model->isNewRecord) { 
                        echo Select2::widget([
                            'name' => 'afromadr',
                            'data' => ArrayHelper::map($maillist,'id','content'),
                            'value' => $maillist[0]['id'],
                            'options' => ['placeholder' => 'Выбрать адрес ...'],
                            'pluginEvents' => [
                                'change' => 'function(event) { var selections = $(this).select2("data"); $("#fromadr").val(selections[0].text);  }'
                            ],
                        ]);

                    } ?>    
                    </td>           
                    <td>
                    <?= Html::activeTextInput($model, 'fromadr', ['id'=>'fromadr','class' => 'form-control',]) ?>
                    </td>
                    </tr></table>
                    </td>
                </tr>
                <tr>
                    <td><?= Html::activeLabel($model, 'date') ?></td>
                    <td><?= Html::activeTextInput($model, 'date', ['class' => 'form-control',]) ?></td>
                </tr>
                <tr>
                    <td><?= Html::activeLabel($model, 'subject') ?></td>
                    <td><?= Html::activeTextInput($model, 'subject', ['class' => 'form-control',]) ?></td>
                </tr>
                <tr>
                    <td><?= Html::activeLabel($model, 'msgcont') ?></td>
                    <td><?= Html::activeTextArea($model, 'msgcont', ['class' => 'form-control','rows'=>'13']) ?></td>
                </tr>
                <tr>
                    <td><?= Html::activeLabel($model, 'msgatt') ?></td>
                    <td><?= Html::activeFileInput($model, 'files[]',['multiple' => 'multiple']) ?>        </td>
                </tr>
                <tr>
                    <td>
                        <?php if($model->isNewRecord) { ?>
                        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?php } ?>
                    </td>
                    <td><?= Html::Button('Выход', ['class' => 'btn','onclick' => 'document.location.href="'.Url::to(['delivery/index']).'"']); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-xs-6">
            <div id="adrslist">
                <?php if($model->isNewRecord) { ?>
                <?= Html::activeTextArea($model, 'toadrs', ['class' => 'form-control','rows'=>'20','readonly'=>'readonly']) ?>
                <?php } else { 
                    echo Html::a('Контроль доставки',Url::to(['delivery/delichek','id'=>$model->id]), ['class' => 'btn btn-sm btn-info']) ;
                    echo GridView::widget([
                        'dataProvider' => $delicont,
                        'rowOptions' => function ($model, $key, $index, $grid)
                            {
                                if($model->err > 1) {
                                    return ['style' => 'background-color:#F2DEDE;'];
                                }
                            },
                        'columns' => [
                            'email',
                            [
                                'label'=>'Клиент',
                                'attribute'=>'kagent.name',
                                'value'=>function($model){
                                    return $model->getKagent()->one()->name;
                                }               
                            ],
                            [
                                'label'=>'Доставка',
                                'attribute'=>'err',
                                'value'=> function($model){
                                    return (($model->err == 0) ? ' ': (($model->err == 1) ? 'ok': 'ошибка !!!')) ;
                                }
                            ],            
                        ],
                    ]); 
                } ?>
            </div>
        </div>  
    </div>
    <?= Html::activeTextInput($model, 'msgerr', ['type' => 'hidden',]) ?>
    <br>

    <?php ActiveForm::end(); ?>

</div>
<?php if($model->isNewRecord) { 
/*
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get']); ?>
    <?= $form->field($searchModel, 'typeKag')->label(false)->widget(Select2::classname(),['data'=>ArrayHelper::map(Spratr::find()->Where(['atrId'=>1])->all(),'id','descr'),'pluginEvents' => ['change' => 'function(e) {  $("#selkagents-filters input:last").val($(this).val());  console.log($("#selkagents-filters input:last").val()); $("#selkagents").yiiGridView("applyFilter");}']])  ?>
    <?php ActiveForm::end(); ?>                    
                    'pluginEvents' => [
                        'change'=>'function(e) { var idsf = aSatr[$("#lev0").val()]; $("#kagentsearch-"+idsf).val($(this).val());  $("#hidesearch").submit(); }',
                    ],    

    <?php Pjax::begin(['enablePushState' => false, 'id' => ('pjaxKAgent'), 'timeout'=>2000]); ?>
    <?php Pjax::end(); ?>

 *  */    
?>
<div id="dialog-toadr" title="Выбор адресатов" style="overflow: hidden; ">
    <div style="display: none">
        <?php 
            $form = ActiveForm::begin(['id' => 'hidesearch' ,'action' => ['seltoadr'],'method' => 'get']);
            foreach (Yii::$app->params['satr'] as $satr) {
                echo $form->field($searchModel, $satr['atrName'])->label(false);
            }
            ActiveForm::end();
            //$aSatr = json_encode(ArrayHelper::map(Yii::$app->params['satr'],'atrId','atrName'));
        ?> 
    </div>    
    <table width="100%" >
        <tr>
            <td width="40%" >
                <?= Select2::widget([
                    'name' => 'asatr',
                    'data' => ArrayHelper::map(Yii::$app->params['satr'],'atrId','atrDescr'),
                    //'value' => ['1'],
                    'options'=>['id'=>'lev0','placeholder' => 'Select ...'],
                ]); ?>                     
            </td>
            <td width="60%" >
                <?= DepDrop::widget([ 
                    'name' => 'asatrdd',
                    'data'=> [],
                    'options' => ['id'=>'lev1','placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['lev0'],
                        'url' => Url::to(['main/getsatr']),
                        'loadingText' => 'Loading child level 1 ...',
                    ],
                ]); ?> 
            </td>
         </tr>    
    </table>
    <?php Pjax::begin(['enablePushState' => false, 'id' => ('pjaxKAgent'), 'timeout'=>2000]); ?>
    <div id="kagentgrid">
            <?= $this->render('fltkag', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]) ?>
    </div>
    <?php Pjax::end(); ?>
</div>
<?php } ?>
<?php
$script = <<< JS
    $( "#sidebar-left" ).remove();
    $( "#content" ).css('width','100%');

    //$("[name='KagentSearch[typeKag]']").attr("id","KStK");    
    $("#goseladr").on("click",function(){ 
        $("#dialog-toadr").dialog('open');
    });
    $("#goclradr").on("click",function(){ 
        $("#delivery-toadrs").val('');
    });
        
    function getRows()
    {
        var strvalue = "";
        $('input[name="selection[]"]:checked').each(function() {
            strvalue = strvalue + ((strvalue!="") ? "," : "")+this.value;
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
                var oldval = $('#delivery-toadrs').val() ;
                if(oldval.length != 0) result = oldval + ", " + result ;
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
                text: 'Выход',
                click: function() { 
                        $(this).dialog('close');
                }
            },
        ]
    });
    $("#lev1").on("change",function(){ 
        var hdata=$("#lev0").val() , ldata=$("#lev1").val();
        if(Number(hdata)>0 && Number(ldata)>0) {
            $.post({
                url: 'seltoadr',
                data: "phdata="+hdata+"&pldata="+ldata,
                success: function(data) { //alert(data);
                    $('#kagentgrid').html(data);
                    $('#selkagents').yiiGridView('setSelectionColumn', {"name":"selection[]","class":null,"multiple":true,"checkAll":"selection_all"}); 
                    //$('#selkagents').yiiGridView({"filterUrl":"\/basic\/web\/delivery\/create","filterSelector":"#selkagents-filters input, #selkagents-filters select"});
                    //$(document).pjax("#pjaxKAgent a", {"push":false,"replace":false,"timeout":2000,"scrollTo":false,"container":"#pjaxKAgent"});    
                }
           });
        }
    });
    $(document).on("pjax:success", "#pjaxKAgent", function (event) { 
        $('#selkagents').yiiGridView('setSelectionColumn', {"name":"selection[]","class":null,"multiple":true,"checkAll":"selection_all"}); 
    });    

JS;
$this->registerJs($script,yii\web\View::POS_END); 
?>        