<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm 

 * style="max-width:100%"
 *  */

use yii\helpers\Html;
use \app\models\Event;

//$cmonth, $evoldm, $cday, $evcurm, $evcurd
$this->params['curmenu'] = 1;
$this->params['leftmenu'] = $this->render('lmmain');
$nmonts = ['01'=>'Январь','02'=>'Февраль','03'=>'Март','04'=>'Апрель','05'=>'Май','06'=>'Июнь','07'=>'Июль','08'=>'Август','09'=>'Сентябрь','10'=>'Октябрь','11'=>'Ноябрь','12'=>'Декабрь'];
$glfc = '<span class="glyphicon glyphicon-folder-close"></span>';
$glfo = '<span class="glyphicon glyphicon-folder-open"></span>';
$glok = '<span class="glyphicon glyphicon-ok"></span>';
?>
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
       <td colspan="2"><?php echo substr($evoldmitems['yearmonth'],0,4)." ".$nmonts[substr($evoldmitems['yearmonth'],5,2)].(($evoldmitems['yearmonth']!=$cmonth) ? '' : $glok);?></td>
       <td><?php echo " Дела : ".($evoldmitems['evact']+$evoldmitems['evnoa'])."  в т.ч. активн.-".$evoldmitems['evact']." закрыто-".$evoldmitems['evnoa'] ; ?></td>
   </tr> 
   <?php } ?>
   <?php foreach ($evcurm as $evcurmitems){ ?>
   <tr class="evdays incldays info <?php echo ($evcurmitems['day']!=$cday) ? 'dayoff' : 'dayon' ; ?>" data-day="<?php echo $evcurmitems['day'];?> ">
       <td></td>
       <td class="foldericon"><?php echo ($evcurmitems['day']!=$cday) ? $glfc : $glfo ; ?> </td>
       <td><?php echo $evcurmitems['day'].(($evcurmitems['day']!=$cday) ? '' : $glok);?></td>
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
