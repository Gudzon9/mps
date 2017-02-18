<?php

namespace app\controllers;

use Yii;
use app\models\Kagent;
use app\models\Spratr;
use app\models\User;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


class RepController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionNewgroup()
    {
        if (\Yii::$app->request->post()) { 
            $post = \Yii::$app->request->post();
            $groupname = $post['pgn'];
            
            if($groupname != '') {
                $model = new Spratr ;
                $model->atrId = 10;
                $model->lvlId = 0;
                $model->descr = $groupname;
                if($model->save()) {
                    $groupid = trim((string)$model->id);
                    $query = $this->getKagentList($post);
                    
                    foreach ($query->all() as $item) {
                        $kagent = Kagent::findOne($item->id);
                        if(strlen(trim($kagent->grouKag))+strlen($groupid)+3 < 100) {
                           if(trim($kagent->grouKag) != '') { 
                                $kagent->grouKag = trim($kagent->grouKag).',['.$groupid.']' ;
                           } else {
                                $kagent->grouKag = '['.$groupid.']' ;  
                           } 
                           $kagent->save();        
                        }
                    } 
                }
            }
            return ;
        }
        return $this->render('newgroup');
    }
    public function actionPrepgroup()
    {
        $post = \Yii::$app->request->post();
        $query = $this->getKagentList($post);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,'pagination' => ['pagesize' => 10,],
        ]);
        $out = \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'name',
            ],    
        ]);
        return $out;
    }
    public function actionPrepsel2()
    {
        $pkat = intval(\Yii::$app->request->post('pkat'));
        if($pkat == '12') {
        $out = Select2::widget([
            'name' => 'selpar',
            'data' => ArrayHelper::map(User::find()->orderBy(['fio'=>SORT_ASC])->all(),'id','fio'),
            'options' => ['class' => 'selpar','placeholder' => 'Ответственный ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
            ],
        ]);                    
            
        } else {
        $out = Select2::widget([
            'name' => 'selpar',
            'data' => ArrayHelper::map(Spratr::find()->Where(['atrId'=>$pkat])->all(),'id','descr'),
            'options' => ['class' => 'selpar ','placeholder' => 'Выбор ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
            ],
        ]);
        }
        return $out;
    }
    public function getKagentList($post) {
        $pfd = $post['pfd'];
        $ptd = $post['ptd'];
        
        $query = \app\models\Kagent::find();
        if($post['psd']=='2') {
            $query->joinWith('coment')
                  ->andWhere(['between','coment.comentDate',$pfd,$ptd]);  
        } else {
            $query->andWhere(['between','enterdate',$pfd,$ptd]);  
        }
        $asatrtype = []; $asatrfld = [];
        foreach (\Yii::$app->params['satr'] as $par) {
            $asatrtype[$par['atrId']] = $par['atrType'];
            $asatrfld[$par['atrId']] = $par['atrName'];
        }
        $pdata = json_decode($post['pdata']);
        foreach ($pdata as $adata) { 
            if($adata->vkat == "12") { 
                $query->andWhere(['in','userId',$adata->vpar]);
            } else { 
                if($asatrtype[$adata->vkat] == 'one') { 
                    $query->andWhere(['in',$asatrfld[$adata->vkat],$adata->vpar]);
                } else { 
                    foreach ($adata->vpar as $apar) {
                        $query->andWhere(['like',$asatrfld[$adata->vkat],'['.$apar.']']);
                    } 
                }
            }
        }
        return $query;
    }
}
