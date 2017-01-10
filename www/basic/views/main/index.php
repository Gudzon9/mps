<?php

use yii\helpers\Html;
use app\models\Event;
use yii\grid\GridView;
use app\models\Ui;
use yii\widgets\Pjax;

$this->params['curmenu'] = 1;
?>
    <table width='100%'>
        <tr>
        <td width='40%' style='vertical-align: top; padding-right: 5px;'>
            <div class="panel panel-info">
                <div id="evtitle" class="panel-heading">Дела</div>
                <div id="evbody" class="panel-body">
                    <?php foreach ($events as $event){ ?>
                    <p>
                        <a style="color: <?php echo $event['color'];?>" class='refevent' data-id='<?php echo $event['id'];?>' title='<?php echo $event['start'];?>'>
                            <?php echo $event['title'];?>
                        </a>
                    </p>
                    <?php } ?>
                    </ul>
                </div>
            </div>    
        </td>    
        <td width='10%' style='vertical-align: top;'>
            <div class="panel panel-info">
                <div class="panel-heading">Просроченные</div>
                <div class="panel-body">
                    <p id="evexpaire" style='text-align: center; font-size: 40px;'>
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
                        <tr id="evtoday">
                            <td>Сегодня</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['todaycnt'];?></td>
                        </tr>
                        <tr id="evtomorow">
                            <td>Завтра</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['tomorowcnt'];?></td>
                        </tr>
                        <tr id="evweek">
                            <td>Неделя</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['weekcnt'];?></td>
                        </tr>
                    </table>
                </div>
            </div>    
        </td>    
        <td width='50%' style='vertical-align: top; ; padding-left: 5px'>
            <div class="panel panel-info">
                <div class="panel-heading">VIP</div>
                <div class="panel-body">
<?=Html::beginForm();?>
     <?=Html::dropDownList('type', 'null',['1'=>'VIP','2'=>'Думает','3'=>'Отказался']); ?>
<?=Html::endForm(); ?>           
                    
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


