<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$itemsrs = ArrayHelper::map($regions,'id','descr');
$itemsts = ArrayHelper::map($towns,'id','descr');
/*
                <td>
                <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'id' => 'goflt']) ?>
                </td>
            <tr><td colspan="2"><?= $form->field($searchModel, 'birthday') ?> <br></td></tr>       

 */
?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading">Сотрудники
	<span class="pull-right clickable "><i class="glyphicon glyphicon-chevron-up"></i></span>
    </div>
    <div class="panel-body" style="display: block">
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get',]); ?>
        <table width="100%">
            <tr><td colspan="2"><?= $form->field($searchModel, 'posada')->dropDownList(Yii::$app->params['aposada'],['prompt' => 'Все ...','onchange'=>'this.form.submit()']) ?></td></tr>
            <tr><td colspan="2"><?= $form->field($searchModel, 'statusEmp')->dropDownList(Yii::$app->params['astatusEmp'],['prompt' => 'Все ...','onchange'=>'this.form.submit()']) ?></td></tr>        
            <tr><td colspan="2"><?= $form->field($searchModel, 'region')->dropDownList($itemsrs,['prompt' => 'Все ...','onchange'=>'this.form.submit()']) ?></td></tr>        
            <tr><td colspan="2"><?= $form->field($searchModel, 'town')->dropDownList($itemsts,['prompt' => 'Все ...','onchange'=>'this.form.submit()']) ?></td></tr>       
            <tr>
                <td colspan="2">
                <?= Html::Button('Сброс фильтров', ['class' => 'btn btn-block', 'id' => 'clearflt']) ?>    
                </td>
            </tr>
        </table>
    <?php ActiveForm::end(); ?>
    </div>
</div>        
 

