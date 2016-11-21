<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm 

 * style="max-width:100%"
 *  */

use yii\helpers\Html;
?>
   <?php foreach ($evpd as $evpditems){ ?>
   <tr class="evday inclevents" data-eventid="<?php echo $evpditems['id'];?> ">
       <td colspan="2"></td>
       <td><?php echo (substr($evpditems['start'],11,2)!='00') ? substr($evpditems['start'],11,5).' - '.substr($evpditems['end'],11,5) : 'весь день';?></td>
       <td><?php echo $evpditems['title'];?></td>
   </tr> 
   <?php } ?>
