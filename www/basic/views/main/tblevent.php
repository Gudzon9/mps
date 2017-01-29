<?php
use yii\helpers\Html;
use yii\helpers\Url;

$today =  date('Y-m-d hh:mm');
$amonts = ['01'=>'янв','02'=>'фев','03'=>'мар','04'=>'апр','05'=>'май','06'=>'июн','07'=>'июл','08'=>'авг','09'=>'сен','10'=>'окт','11'=>'ноя','12'=>'дек'];
$maxcnt = ($top == 'top') ? 5 : 500 ; 
/*
<table id="evtbl" class='table table-condensed table-hover '>
    <thead>
        <tr>
            <td><b>Клиент</b></td>
            <td><b>Дело</b></td>
            <td><b>Дата</b></td>
            <td><b>Пр.</b></td>
        </tr>    
    </thead>
    <tbody>
        <tr class='off refevent' style='cursor: pointer' data-id='<?php echo $event['id'];?>' data-prim='<?php echo $event['prim'];?>' data-status='<?php echo $event['status'];?>'>
            <td><?php echo $event['klient'];?></td>
            <td style="color: <?php echo $event['color'];?>"><?php echo $event['type'];?></td>
            <td style="color: <?php echo ($event['start'] < $today) ? 'red' : '' ;?>"><?php echo substr($event['start'], 8, 2).substr($event['start'], 4, 4).substr($event['start'], 2, 2);?></td>
            <td><?php echo (trim($event['prim']) != '') ? '<span class="glyphicon glyphicon-paperclip"></span>' : ' '  ;?></td>
        </tr>
    </tbody>
</table>
 * 'style'=>['height'=>'22px','font-size'=>'12px']
 */
//echo '<table>';
$i = 0;
foreach ($events as $event){ 
    if($i < $maxcnt) {
        echo '<p style="height: 25px">';
        echo Html::a(trim($event['prim']).' • <b>'.trim($event['klient']).'</b><span style="color: '.(($event['start'] < $today) ? 'red' : '').'"> • '.substr($event['start'],8,2).' '.$amonts[substr($event['start'],5,2)].' '.substr($event['start'],0,4).substr($event['start'],10,6).'</span> <span style="border-style: solid; border-width: 1px; padding-left: 5px; padding-right: 5px; border-color:'.$event['color'].'; color: '.$event['color'].'"> '.$event['type'].' </span>' , Url::to(['crm/update','id'=>$event['id_klient']]),['style'=>['text-decoration'=>'none']]); 
        echo '</p>';
    }
    $i++;
}
//echo '</table>';
if($i > $maxcnt) {
    echo '<br> <div id="showallev" style="height: 50px; background: #EEE; cursor: pointer; padding-left: 50px;"><br><span class="glyphicon glyphicon-chevron-down"></span>  Показать остальные дела : '.($i - $maxcnt).'</div>';
}

?>
