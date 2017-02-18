<?php

namespace app\controllers;

use Yii;
use app\models\Addatr;
use app\models\Kagent;
use app\models\KagentSearch;
use app\models\Spratr;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
//use yii\filters\VerbFilter;
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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'allow' => TRUE,
                    'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        /*
        if (Yii::$app->user->isGuest){
            return $this->goHome();
        }
        */
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
        if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
            $fltuserId = Yii::$app->user->identity->id;   
        } else {$fltuserId = NULL;}
        $events = $this->searchv2($fltuserId,'All');
        $top = 'top';
        $stats = ['overdue'=>0,'todaycnt'=>0,'tomorowcnt'=>0,'weekcnt'=>0,];
        foreach ($events as $event) {
            $eventstart = substr($event['start'],0,10);
            if($eventstart < $today) $stats['overdue']++;
            if($eventstart == $today) $stats['todaycnt']++;
            if($eventstart == $tomorow) $stats['tomorowcnt']++;
            if($eventstart > $last_Monday && $eventstart < $end_week) $stats['weekcnt']++;
        }
        /*
        $flt['fldname'] = 'typeKag';
        $flt['fldvalue'] = 441;
        $flt['fldtype'] = 'one' ;
        $dataProvider = $this->getdataprovider($flt);
        */
        
        $searchModel = new KagentSearch();
        if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
            $filter['userId'] = Yii::$app->user->identity->id;   
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filter);
        
        return $this->render('index',[
            'events' => $events,
            'top' => $top,
            'stats' => $stats,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'choiceMode' => false,
            ]);
    }
    public function actionUpdate($id)
    {
        return $this->redirect(['crm/update','id'=>$id],302);
    }
    public function actionGetevwflt()
    {
        if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
            $fltuserId = Yii::$app->user->identity->id;   
        } else {$fltuserId = NULL;}
        $sparam = Yii::$app->request->post('pflt');
        $top = Yii::$app->request->post('ptop');
        $events = $this->searchv2($fltuserId,$sparam,$top);
        
        return $this->renderPartial('tblevent',['events' => $events,'top' => $top]); 
    } 
    public function searchv2($emplid=NULL,$flt) {
        $today =  date('Y-m-d');
        $tomorow = date("Y-m-d",strtotime("$today + 1 day"));
        $last_Monday = date("Y-m-d",strtotime("last Monday"));
        $end_week = date("Y-m-d",strtotime("$last_Monday + 7 day"));
        $event = \app\models\Event::find()
            ->orderBy(['start'=>SORT_DESC])
            ->andWhere(['status'=>0])
            ->leftJoin('kagent','kagent.id=event.id_klient')
            ->andFilterWhere(['kagent.userId'=>$emplid]);
        switch ($flt){
            case 'evexpaire':
                $event->andWhere('LEFT(start,10) < :curDate',[':curDate' => $today]);
                break;
            case 'evtoday':
                $event->andWhere('LEFT(start,10) = :curDate',[':curDate' => $today]);
                break;
            case 'evtomorow':
                $event->andWhere('LEFT(start,10) = :curDate',[':curDate' => $tomorow]);
                break;
            case 'evweek':
                $event->andWhere('LEFT(start,10) >= :begDate',[':begDate' => $last_Monday])
                    ->andWhere('LEFT(start,10) <= :endDate',[':endDate' => $end_week]);
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
    /*    public function actionGetkagents()
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

    public function getdataprovider($fltparams)
    {        //var_dump($fltparams);
        if($fltparams['fldtype']=='one') {
            $query = Kagent::find()->Where([$fltparams['fldname'] => $fltparams['fldvalue']]);
        } else {
            //$avalues = explode(',', $fltparams['fldname']);
            $search = '['.$fltparams['fldvalue'].']';
            $query = Kagent::find()->Where(['like', $fltparams['fldname'], $search ]);
            
        }
        if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
            $query->andWhere(['userId' => Yii::$app->user->identity->id]);
        }
        
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $provider;
     } 
     */
}
