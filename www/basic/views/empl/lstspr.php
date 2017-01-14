<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Spratr;

//$itemsregions = ArrayHelper::map($dataregion,'id','descr');
$adata=[1=>'one',2=>'two'] ;
$this->title = 'Справочник ['.Yii::$app->params['satr'][$atrid]['atrDescr'].']';
$this->params['curmenu'] = 2;
$this->params['cursubmenu'] = 4;
$this->params['leftmenu'] = $this->render('lmaspr');
?>
<table width="100%">
    <tr>
        <td style="text-align:left"><h1><?= Html::encode($this->title) ?></h1></td>
        <td style="text-align:right"><?= Html::a('Добавить элемент', ['newspr','atrid'=>$atrid], ['class' => 'btn btn-success']) ?>   </td>
    </tr>
</table>

 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'descr',
            [
                'attribute'=>'lvlId',
                'value'=>function($model){

                    if($model->lvlId != 0) {
                        $obj = Spratr::findOne($model->lvlId);
                        $retval = $obj->descr;
                    } else {
                        $retval = '';
                    }    
                            //->select(['descr'])->where(['id'=>$model->lvlId])->one();
                    return $retval;
                },
                'label'=> (($atrid==8) ? 'Область' : ''),        
            ],            
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update}',  
             'urlCreator' => function($action, $model, $key, $index){
            return \yii\helpers\Url::to(['empl/updspr','id'=>$model->id]);
            }   
            ],
        ],
    ]); 
?>

  
