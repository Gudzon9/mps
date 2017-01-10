<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Справочник ['.Yii::$app->params['satr'][$atrid]['atrDescr'].']';
$this->params['curmenu'] = 2;
$this->params['cursubmenu'] = 4;
$this->params['leftmenu'] = $this->render('lmaspr');
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= Html::a('Добавить', ['newspr','atrid'=>$atrid], ['class' => 'btn btn-success']) ?>   
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'descr',
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update}',  
             'urlCreator' => function($action, $model, $key, $index){
            return \yii\helpers\Url::to(['empl/updspr','id'=>$model->id]);
            }   
            ],
        ],
    ]); 
?>

  
