<?php
$today =  date('Y-m-d');
?>
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
            <td style="color: <?php echo ($event['start'] < $today) ? 'red' : '' ;?>"><?php echo substr($event['start'], 8, 2).substr($event['start'], 4, 4).substr($event['start'], 2, 2);?></td>
            <td><?php echo $event['prim'];?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
