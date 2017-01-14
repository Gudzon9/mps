<?php

namespace app\controllers;

use Yii;
use app\models\Addatr;
use app\models\Kagent;
use app\models\KagentSearch;
use app\models\Spratr;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

class MainController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest){
            return $this->goHome();
        }
        if ($action->actionMethod!='actionIndex' && !Yii::$app->request->isAjax){
            return $this->goHome();
        }
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        $today =  date('Y-m-d');
        $tomorow = date("Y-m-d",strtotime("$today + 1 day"));
        $last_Monday = date("Y-m-d",strtotime("last Monday"));
        $end_week = date("Y-m-d",strtotime("$last_Monday + 7 day"));
        //$sparam = ['fltempl' => Yii::$app->user->identity->id, 'cday' => $cday, 'last_Monday' => $last_Monday, 'end_week' => $end_week,];
        $events = $this->searchv2(Yii::$app->user->identity->id,'All');

        $stats = ['overdue'=>0,'todaycnt'=>0,'tomorowcnt'=>0,'weekcnt'=>0,];
        foreach ($events as $event) {
        if($event['start'] < $today) $stats['overdue']++;
            if($event['start'] == $today) $stats['todaycnt']++;
            if($event['start'] == $tomorow) $stats['tomorowcnt']++;
            if($event['start'] > $last_Monday && $event['start'] < $end_week) $stats['weekcnt']++;
        }
        
        $flt['fldname'] = 'typeKag';
        $flt['fldvalue'] = 441;
        $flt['fldtype'] = 'one' ;
        $dataProvider = $this->getdataprovider($flt);
        
        return $this->render('index',[
            'events' => $events,
            'stats' => $stats,
            'dataProvider' => $dataProvider,
            ]);
    }
    public function actionGetevwflt()
    {
        $sparam = Yii::$app->request->post('pflt');
        $events = $this->searchv2(Yii::$app->user->identity->id,$sparam);
        foreach ($events as $event){ 
            echo "<p><a style='color: ".$event['color']."' class='refevent' data-id='".$event['id']."' title='".$event['start']."'>".$event['title']."</a></p>";
        } 
    } 
    public function searchv2($emplid,$flt) {
        $today =  date('Y-m-d');
        $tomorow = date("Y-m-d",strtotime("$today + 1 day"));
        $last_Monday = date("Y-m-d",strtotime("last Monday"));
        $end_week = date("Y-m-d",strtotime("$last_Monday + 7 day"));
        $event = \app\models\Event::find()
            ->andWhere(['status'=>0])
            ->leftJoin('kagent','kagent.id=event.id_klient')
            ->andFilterWhere(['kagent.userId'=>$emplid]);
        switch ($flt){
            case 'evexpaire':
                $event->andWhere('start < :curDate',[':curDate' => $today]);
                break;
            case 'evtoday':
                $event->andWhere('start = :curDate',[':curDate' => $today]);
                break;
            case 'evtomorow':
                $event->andWhere('start = :curDate',[':curDate' => $tomorow]);
                break;
            case 'evweek':
                $event->andWhere('start >= :begDate',[':begDate' => $last_Monday])
                    ->andWhere('start <= :endDate',[':endDate' => $end_week]);
                break;
        };
        
        return $event->asArray()->all();
    }
    public function actionGeteventbyid()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \app\models\Event::findOne(Yii::$app->request->post('pid'));
    }        
    public function actionEditevent()
    {
        $aRec['Event']=Yii::$app->request->post();
        $model = \app\models\Event::findOne($aRec['Event']['id']);
        if ($model->load($aRec)) {
            if (!$model->save()){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->getErrors();
            }
        }
    }
    public function actionGetsatr()
    {
        $out = [];
        $id = Yii::$app->request->post('depdrop_parents');
        if (isset($id)) {
            $list = Spratr::find()->andWhere(['atrId'=>$id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['id'], 'name' => $account['descr']];
                    if ($i == 0) {
                        $selected = $account['id'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
    public function actionGetkagents()
    {
        $post = Yii::$app->request->post();
        $psatr = intval($post['psatr']);
        $pvatr = intval($post['pvatr']);
        $flt['fldname'] = Yii::$app->params['satr'][$psatr]['atrName'];
        $flt['fldvalue'] = $pvatr;
        $flt['fldtype'] = ($psatr == 5 || $psatr == 9) ? 'many' : 'one' ;
        $dataProvider = $this->getdataprovider($flt);
        
        return $this->renderAjax('gridkagent',['dataProvider' => $dataProvider]);
    }
    /*
     * $fltparams[fldname] -  
     */
    public function getdataprovider($fltparams)
    {        //var_dump($fltparams);
        if($fltparams['fldtype']=='one') {
            $query = Kagent::find()->Where([$fltparams['fldname'] => $fltparams['fldvalue']]);
        } else {
            //$avalues = explode(',', $fltparams['fldname']);
            $search = '['.$fltparams['fldvalue'].']';
            $query = Kagent::find()->Where(['like', $fltparams['fldname'], $search ]);
            
        }
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $provider;
     }        
}
