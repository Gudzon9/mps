<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Kagent;
use yii\grid\GridView;
                    
echo      GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                'label' => 'Клиент',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model->name,\yii\helpers\Url::to(['crm/update','id'=>$model->id]));
                }
                ],
                [
                'label'=>'Телефон',
                'attribute'=>'addatr.tel',
                'format'=>'html',
                'value'=>function($model){
                    $str ='';
                    foreach ($model->getAddAtrs(1)->all() As $item)
                    {
                        $str.=$item['content'].' '.$item['note'].'<br>';
                    }
                    return $str;
                }
                ]
            ],
        ]); 

