<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm 

 * style="max-width:100%"
 *  */

use yii\helpers\Html;
?>
   <?php foreach ($evpm as $evpmitems){ ?>
   <tr class="evdays info incldays" data-day="<?php echo $evpmitems['day'];?> ">
       <td></td>
       <td class="foldericon"><span class="glyphicon glyphicon-folder-close"></span></td>
       <td><?php echo $evpmitems['day'];?></td>
       <td><?php echo " Дела : ".($evpmitems['evact']+$evpmitems['evnoa'])."  в т.ч. активн.-".$evpmitems['evact']." закрыто-".$evpmitems['evnoa'] ; ?></td>
   </tr> 
   <?php } ?>
