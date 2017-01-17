<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$itemsrs = ArrayHelper::map($regions,'id','descr');
$itemsts = ArrayHelper::map($towns,'id','descr');
?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading">Сотрудники
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: block">
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get',]); ?>
        <table width="100%">
            <tr><td colspan="2"><?= $form->field($searchModel, 'posada')->dropDownList(Yii::$app->params['aposada'],['prompt' => 'Все ...']) ?></td></tr>
            <tr><td colspan="2"><?= $form->field($searchModel, 'statusEmp')->dropDownList(Yii::$app->params['astatusEmp'],['prompt' => 'Все ...']) ?></td></tr>        
            <tr><td colspan="2"><?= $form->field($searchModel, 'region')->dropDownList($itemsrs,['prompt' => 'Все ...']) ?></td></tr>        
            <tr><td colspan="2"><?= $form->field($searchModel, 'town')->dropDownList($itemsts,['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'birthday') ?> <br></td></tr>       
            <tr><td>
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'id' => 'goflt']) ?>
            </td>
            <td>
        <?= Html::Button('Сброс', ['class' => 'btn', 'id' => 'clearflt']) ?>    
            </td></tr>
        </table>
    <?php ActiveForm::end(); ?>
    </div>
</div>        
 

