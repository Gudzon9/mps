<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Spratr;

function getarrsaratr($param) {
    return ArrayHelper::map(Spratr::find()->Where(['atrId'=>$param])->all(),'id','descr');
}

?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading">Клиенты
	<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
    </div>
    <div class="panel-body" style="display: block">
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get',]); ?>
        <table width="100%">
            <tr><td colspan="2"><?= $form->field($searchModel, 'kindKagent')->dropDownList(Yii::$app->params['akindKagent'],['prompt' => 'Все ...']) ?></td></tr>
            <tr><td colspan="2"><?= $form->field($searchModel, 'typeKag')->dropDownList(getarrsaratr(1),['prompt' => 'Все ...']) ?></td></tr>        
            <tr><td colspan="2"><?= $form->field($searchModel, 'statKag')->dropDownList(getarrsaratr(2),['prompt' => 'Все ...']) ?></td></tr>        
            <tr><td colspan="2"><?= $form->field($searchModel, 'actiKag')->dropDownList(getarrsaratr(3),['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'chanKag')->dropDownList(getarrsaratr(4),['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'regiKag')->dropDownList(getarrsaratr(7),['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'townKag')->dropDownList(getarrsaratr(8),['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'prodKag')->dropDownList(getarrsaratr(5),['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'tpayKag')->dropDownList(getarrsaratr(9),['prompt' => 'Все ...']) ?></td></tr>       
            <tr><td colspan="2"><?= $form->field($searchModel, 'grouKag')->dropDownList(getarrsaratr(10),['prompt' => 'Все ...']) ?></td></tr>       
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

