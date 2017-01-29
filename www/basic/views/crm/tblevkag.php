<?php
$today =  date('Y-m-d hh:mm');
$amonts = ['01'=>'янв','02'=>'фев','03'=>'мар','04'=>'апр','05'=>'май','06'=>'июн','07'=>'июл','08'=>'авг','09'=>'сен','10'=>'окт','11'=>'ноя','12'=>'дек'];
?>
<table width="100%">
    <?php foreach ($model->getEvents()->Where(['status'=>0])->all() as $event){ ?>
    <tr class="refevent off" style="margin-left: 5px; cursor: pointer" data-id="<?= $event['id']; ?>" data-prim="<?= $event['prim']; ?>" data-start="<?= $event['start']; ?>" data-idtype="<?= $event['id_type']; ?>">
        <td><br><?= trim($event['prim']).' • <b>'.trim($event['klient']).'</b><span style="color: '.(($event['start'] < $today) ? 'red' : '').'"> • '.substr($event['start'],8,2).' '.$amonts[substr($event['start'],5,2)].' '.substr($event['start'],0,4).substr($event['start'],10,6).'</span> <span style="border-style: solid; border-width: 1px; padding-left: 5px; padding-right: 5px; border-color:'.$event['color'].'; color: '.$event['color'].'">'.$event['type'].'</span>' ; ?></td>
    </tr>
    <?php } ?>
</table>
