<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Event;
//use yii\grid\GridView;
use app\components\GridView;
use app\models\Ui;
use app\models\Spratr;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/*
 * http://stackoverflow.com/questions/25305752/yii-2-0-gridview-update
    <a style="color: <?php echo $event['color'];?>" class='refevent' data-id='<?php echo $event['id'];?>' title='<?php echo $event['start'];?>'>
    <?php echo $event['title'];?>
    </a>
         
         <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                'label' => 'Клиент',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->name,\yii\helpers\Url::to(['crm/update','id'=>$model->id]));
                }
                ],
                [
                'label'=>'Телефон',
                'attribute'=>'addatr.tel',
                'format'=>'html',
                'value'=>function($model){
                    $str ='';
                    foreach ($model->getAddAtrs(1)->all() As $item)
                    {
                        $str.=$item['content'].' '.$item['note'].'<br>';
                    }
                    return $str;
                }
                ]
            ],
        ]); ?>
 <?= Html::beginForm();?>
<?= Html::endForm(); ?>  
 *  <?php Pjax::begin() ?>   
 * <?php Pjax::end(); ?>
 * 
 * <?= $this->render('gridkagent',['dataProvider' => $dataProvider]); ?>                    
                    <table class='table table-condensed table-hover '>
                        <thead>
                        <tr>
                            <td><b>Клиент</b></td>
                            <td><b>Дело</b></td>
                            <td><b>Дата</b></td>
                            <td><b>Прим.</b></td>
                        </tr>    
                        </thead>
                        <tbody>
                    <?php foreach ($events as $event){ ?>
                    <tr class='refevent' style='cursor: pointer' data-id='<?php echo $event['id'];?>' >
                        <td><?php echo $event['klient'];?></td>
                        <td style="color: <?php echo $event['color'];?>"><?php echo $event['type'];?></td>
                        <td><?php echo substr($event['start'], 8, 2).substr($event['start'], 4, 4).substr($event['start'], 2, 2);?></td>
                        <td><?php echo $event['prim'];?></td>
                    </tr>
                    <?php } ?>
                        </tbody>
                    </table>
 
                 <table width="100%" >
                    <tr>
                        <td width="30%" >
                        <?= Select2::widget([
                            'name' => 'asatr',
                            'data' => ArrayHelper::map(Yii::$app->params['satr'],'atrId','atrDescr'),
                            'value' => ['1'],
                            'options'=>['id'=>'lev0'],
                        ]); ?>                     
                        </td>
                        <td width="60%" >
<?= $form->field($searchModel, 'typeKag')->label(false)->widget(DepDrop::classname(),[
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
                        <td width="10%" >
                        <?= Html::submitButton('GO',['class' => 'btn btn-info','id' => 'refrkag','data-pjax'=>1]); ?>    
                        </td>    
                    </tr>    
                </table>

  
 *  * <?= $form->field($searchModel, 'typeKag')->dropDownList(ArrayHelper::map(Spratr::find()->Where(['atrId'=>1])->all(),'id','descr'),['prompt' => 'Все ...']) ?>              

    <?= DepDrop::widget([
 */

$this->params['curmenu'] = 1;
?>
    <table width='100%'>
        <tr>
        <td width='50%' style='vertical-align: top; padding-right: 5px;'>
            <div class="panel panel-info">
                <div id="evtitle" class="panel-heading">Дела</div>
                <div id="evbody" class="panel-body">
                <?= $this->render('tblevent',['events' => $events,'top' => $top]); ?>
                </div>
            </div>    
        </td>    
        <td width='10%' style='vertical-align: top;' id='evstat' data-stat='all'>
            <div class="panel panel-info">
                <div class="panel-heading">Просроченные</div>
                <div class="panel-body" id="evexpaire" style='cursor: pointer'>
                    <p  style='text-align: center; font-size: 40px;'>
                        <?php echo $stats['overdue'];?>
                    </p>
                </div>
            </div>    
            <br><br><br><br><br><br>
            <div class="panel panel-info">
                <div class="panel-heading">Дела</div>
                <div class="panel-body">
                    <table width='100%'>
                        <tr><th width='50%'></th><th width='50%'></th></tr>
                        <tr id="evtoday" style='cursor: pointer'>
                            <td>Сегодня</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['todaycnt'];?></td>
                        </tr>
                        <tr id="evtomorow" style='cursor: pointer'>
                            <td>Завтра</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['tomorowcnt'];?></td>
                        </tr>
                        <tr id="evweek" style='cursor: pointer'>
                            <td>Неделя</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['weekcnt'];?></td>
                        </tr>
                    </table>
                </div>
            </div>    
        </td>    
        <td width='40%' style='vertical-align: top; ; padding-left: 5px'>
            <div class="panel panel-info">
                <div class="panel-heading">Клиенты</div>

                <div class="panel-body">
                 
                <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get']); ?>
                    <?= $form->field($searchModel, 'typeKag')->label(false)->widget(Select2::classname(),['data'=>ArrayHelper::map(Spratr::find()->Where(['atrId'=>1])->all(),'id','descr'),'pluginEvents' => ['change' => 'function(event) { $(this).parents("form").submit();}']]) ?>
                <?php ActiveForm::end(); ?>                    
                <div id="grkag">
    <?php Pjax::begin(['enablePushState' => false, 'id' => ('pjaxKAgent'), 'timeout'=>2000]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'modelName' => 'MainKagent',
        'edtType'=>'noModal',
        'Edt'=>'nomanual',
        'ui'=>new Ui(),         
        'columns' => [
            'name',
            [
                'label'=>'Город',
                'attribute' => 'townKag',
                'value'=>function($model){
                    return $model->getTown()->one()->descr;
                }               
            ],
            [
                'label'=>'Телефон',
                'attribute'=>'addatr.tel',
                'format'=>'html',
                'value'=>function($model){
                    $str ='';
                    foreach ($model->getAddAtrs(1)->all() As $item)
                    {
                        $str.=$item['content'].' '.$item['note'].'<br>';
                    }
                    return $str;
                }
            ],
            [
                'label'=>'Коментарии',
                'attribute' => 'coment',
                'format'=>'html',
                'value'=>function($model){
                    $str =''; 
                    $counter = 0;
                    foreach ($model->getAddComents()->orderBy(['comentDate'=>SORT_DESC])->all() As $item)
                    {
                        if($counter == 0) {
                            $str.=substr(($item['comentDate'].' '.$item['descr']),0,50).' ...';
                        }     
                        $counter++ ;
                    }
                    return $str.(($counter > 1) ? '<br> еще коментариев :'.($counter-1) : '');
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
                </div>         
                </div>

            </div>    
        </td>
        </tr>   
    </table>    

<div id="dialog-form" title="Дело" style="overflow: hidden; ">
    <p class="validateTips"></p>
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <label for="event_type" class="col-sm-2 control-label">Тип</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="event_type" name="event_type" value="" readonly>
            </div>    
            <label for="event_status" class="col-sm-2 control-label">Статус</label>
            <div class="col-sm-4">
                <input type="checkbox" class="form-control s-flip" name="event_status" id="event_status" data-size="small" data-on-color="info" data-on-text="Завершено" data-off-text="Активно" toglemenu data-label-text="Дело" />
            </div>
        </div>
        <div class="form-group">
            <label for="event_start" class="col-sm-2 control-label">Начало</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="event_start" id="event_start"/>
            </div>    
            <label for="event_end" class="col-sm-2 control-label">Конец</label>
            <div class="col-sm-4" id="div_event_end">
                <input type="text" class="form-control" name="event_end" id="event_end"/>
            </div>    
        </div>
        <div class="form-group" >
            <label for="event_klient" class="col-sm-2 control-label">Клиент</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="event_klient" id="event_klient" readonly/>
            </div>    
        </div>
        <div class="form-group">
            <label for="event_prim" class="col-sm-2 control-label">Примечание</label>
            <div class="col-sm-10">
                <textarea rows="2" class="form-control" name="event_prim" id="event_prim"/></textarea>
            </div>    
        </div>
        <input type="hidden" name="event_id" id="event_id" value="">
        <input type="hidden" name="event_allday" id="event_allday" value="false">
        <input type="hidden" name="event_color" id="event_color" value="">
        <input type="hidden" name="event_id_klient" id="event_id_klient" value="">
        <input type="hidden" name="event_id_type" id="event_id_type" value="">
        
    </form>
</div>


