<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm 

 * style="max-width:100%"
 *  */

use yii\helpers\Html;
use app\models\Event;
use app\components\GridView;
use app\models\Ui;
use yii\widgets\Pjax;

//$cmonth, $evoldm, $cday, $evcurm, $evcurd
$this->params['curmenu'] = 1;
//$this->params['leftmenu'] = $this->render('lmmain');
/*
$nmonts = ['01'=>'Январь','02'=>'Февраль','03'=>'Март','04'=>'Апрель','05'=>'Май','06'=>'Июнь','07'=>'Июль','08'=>'Август','09'=>'Сентябрь','10'=>'Октябрь','11'=>'Ноябрь','12'=>'Декабрь'];
$glfc = '<span class="glyphicon glyphicon-folder-close"></span>';
$glfo = '<span class="glyphicon glyphicon-folder-open"></span>';
$glok = '<span class="glyphicon glyphicon-ok"></span>';
 * 
<table id="listevents" class="table table-hover" width="100%" >
    <thead>
        <tr>
            <th style="width: 8px;padding: 2px;"></th> 
            <th style="width: 8px;padding: 2px;"></th> 
            <th style="width: 100px;padding: 2px;"></th> 
            <th></th>
        </tr>
    </thead> 
   <?php foreach ($evoldm as $evoldmitems){ ?>
   <tr class="evmonths success <?php echo ($evoldmitems['yearmonth']!=$cmonth) ? 'monthoff' : 'monthon' ; ?>" data-yearmonth="<?php echo $evoldmitems['yearmonth'];?> ">
       <td class="foldericon"><?php echo ($evoldmitems['yearmonth']!=$cmonth) ? $glfc : $glfo ; ?> </td>
       <td colspan="2"><?php echo substr($evoldmitems['yearmonth'],0,4)." ".$nmonts[substr($evoldmitems['yearmonth'],5,2)]." ".(($evoldmitems['yearmonth']!=$cmonth) ? '' : $glok);?></td>
       <td><?php echo " Дела : ".($evoldmitems['evact']+$evoldmitems['evnoa'])."  в т.ч. активн.-".$evoldmitems['evact']." закрыто-".$evoldmitems['evnoa'] ; ?></td>
   </tr> 
   <?php } ?>
   <?php foreach ($evcurm as $evcurmitems){ ?>
   <tr class="evdays incldays info <?php echo ($evcurmitems['day']!=$cday) ? 'dayoff' : 'dayon' ; ?>" data-day="<?php echo $evcurmitems['day'];?> ">
       <td></td>
       <td class="foldericon"><?php echo ($evcurmitems['day']!=$cday) ? $glfc : $glfo ; ?> </td>
       <td><?php echo $evcurmitems['day']." ".(($evcurmitems['day']!=$cday) ? '' : $glok);?></td>
       <td><?php echo " Дела : ".($evcurmitems['evact']+$evcurmitems['evnoa'])."  в т.ч. активн.-".$evcurmitems['evact']." закрыто-".$evcurmitems['evnoa'] ; ?></td>
   </tr> 
   <?php } ?>
   <?php foreach ($evcurd as $evcurditems){ ?>
   <tr class="evday inclevents" data-eventid="<?php echo $evcurditems['id'];?> ">
       <td colspan="2"></td>
       <td><?php echo (substr($evcurditems['start'],11,2)!='00') ? substr($evcurditems['start'],11,5).' - '.substr($evcurditems['end'],11,5) : 'весь день';?></td>
       <td><?php echo $evcurditems['title'];?></td>
   </tr> 
   <?php } ?>
</table>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-6">
 
  
  
 */
?>
    <table width='100%'>
        <tr>
        <td width='40%' style='vertical-align: top;'>
            <div class="panel panel-info">
                <div class="panel-heading">Незавершенные</div>
                <div class="panel-body">
                    <?php foreach ($events as $event){ ?>
                    <p><a class='refevent' data-id='<?php echo $event['id'];?>' title='<?php echo $event['start'];?>'>
                            <?php echo $event['title'];?>
                        </a></p>
                    <?php } ?>
                    </ul>
                </div>
            </div>    
        </td>    
        <td width='10%' style='vertical-align: top;'>
            <div class="panel panel-info">
                <div class="panel-heading">Просроченные</div>
                <div class="panel-body">
                    
                    <p style='text-align: center; font-size: 40px;'><?php echo $stats['overdue'];?></p>
                </div>
            </div>    
            <br><br><br><br><br><br>
            <div class="panel panel-info">
                <div class="panel-heading">Дела</div>
                <div class="panel-body">
                    <table width='100%'>
                        <tr><th width='50%'></th><th width='50%'></th></tr>
                        <tr>
                            <td>Сегодня</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['todaycnt'];?></td>
                        </tr>
                        <tr>
                            <td>Завтра</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['tomorowcnt'];?></td>
                        </tr>
                        <tr>
                            <td>Неделя</td>
                            <td style='text-align: right; font-size: 40px;'><?php echo $stats['weekcnt'];?></td>
                        </tr>
                    </table>
                </div>
            </div>    
        </td>    
        <td width='50%' style='vertical-align: top;'>
            <div class="panel panel-info">
                <div class="panel-heading">VIP</div>
                <div class="panel-body">
    <?php Pjax::begin(['enablePushState' => false, 'id' => ($choiceMode?uniqid():'pjaxKAgent'), 'timeout'=>2000]); ?>

    <?= GridView::widget([
        'id'=>uniqid(),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'modelName' => 'Kagent',
        'edtType'=>'Modal',
        'Edt'=>'manual',
        'ui'=>new Ui(),         
        'columns' => [
            'name',
            'city',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
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


