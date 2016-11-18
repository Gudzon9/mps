<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\components\GridView;
use app\models\Ui;
use yii\widgets\Pjax;
//use yii\web\Controller;

$this->title = 'CRM';
$this->params['curmenu'] = 4;
$this->params['cursubmenu'] = 1;
//$this->params['leftmenu'] = $this->render('lmcrm', ['items' => $items,]);
        
?>
<div class="kagent-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['enablePushState' => false, 'id' => ($choiceMode?uniqid():'pjaxKAgent')]); ?>
    <a href="#" typebtn="KagentNew" class="btn-xs btn-info">Добавить</a>

    <?= GridView::widget([
        'id'=>uniqid(),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'modelName' => 'Kagent',
        'edtType'=>'Modal',
        'ui'=>new Ui(),         
        'columns' => [
            'name',
            [
               'attribute' => 'kindKagent',
               'filter' => Yii::$app->params['akindKagent'],
            ],
            'typeKagent',
            'companyId',
            // 'posada',
            // 'birthday',
            // 'kuindActivity',
            // 'userId',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>



