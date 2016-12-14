<?php

namespace app\controllers;

use Yii;
use app\models\Addatr;
use app\models\Kagent;
use app\models\KagentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $today =  date('Y-m-d');
        $tomorow = date("Y-m-d",strtotime("$today + 1 day"));
        $last_Monday = date("Y-m-d",strtotime("last Monday"));
        $end_week = date("Y-m-d",strtotime("$last_Monday + 7 day"));
        //$sparam = ['fltempl' => Yii::$app->user->identity->id, 'cday' => $cday, 'last_Monday' => $last_Monday, 'end_week' => $end_week,];
        $events = $this->searchv2(Yii::$app->user->identity->id);

        $stats = ['overdue'=>0,'todaycnt'=>0,'tomorowcnt'=>0,'weekcnt'=>0,];
        foreach ($events as $event) {
        if($event['start'] < $today) $stats['overdue']++;
            if($event['start'] == $today) $stats['todaycnt']++;
            if($event['start'] == $tomorow) $stats['tomorowcnt']++;
            if($event['start'] > $last_Monday && $event['start'] < $end_week) $stats['weekcnt']++;
        }

        $searchModel = new KagentSearch();
        $filter['kindKagent'] = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$filter);
        
        return $this->render('index',[
            'events' => $events,
            'stats' => $stats,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'choiceMode' => false,
            ]);
        
/*
        $sparam = ['fltempl' => 0, 'fltklient' => 0, 'fltstatus' => 'all', 'flttypes' => '*',];

        $cmonth =  substr(date('Y-m-d'),0,7);
        $cday =  date('Y-m-d');

        $sparam['acttype'] = 'groupmonth';
        $sparam['actparam'] = $cmonth;
        $evoldm = $this->search($sparam);

        $sparam['acttype'] = 'groupday';
        $sparam['actparam'] = $cmonth ;
        $evcurm = $this->search($sparam);

        $sparam['acttype'] = 'nogroup';
        $sparam['actparam'] = $cday;
        $evcurd = $this->search($sparam);
        
        return $this->render('index',
            ['cmonth' => $cmonth,'evoldm' => $evoldm,'cday' => $cday,'evcurm' => $evcurm,'evcurd' => $evcurd]);
 */
    }
    public function actionFltindex()
    {
        $sparam = Yii::$app->request->post();

        $cmonth =  substr(date('Y-m-d'),0,7);
        $cday =  date('Y-m-d');
        
        $sparam['acttype'] = 'groupmonth';
        $sparam['actparam'] = $cmonth;
        $evoldm = $this->search($sparam);

        $sparam['acttype'] = 'groupday';
        $sparam['actparam'] = $cmonth ;
        $evcurm = $this->search($sparam);

        $sparam['acttype'] = 'nogroup';
        $sparam['actparam'] = $cday;
        $evcurd = $this->search($sparam);
        
        return $this->renderPartial('index',
            ['cmonth' => $cmonth,'evoldm' => $evoldm,'cday' => $cday,'evcurm' => $evcurm,'evcurd' => $evcurd]);
    }
    public function actionSearchempl()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \app\models\User::find()->select(['id','fio as value'])->Where(['like','fio',Yii::$app->request->get('term')])->limit(20)->asArray()->all();
    }
    public function actionSearchklient()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \app\models\Kagent::find()->select(['id','name as value'])->Where(['like','name',Yii::$app->request->get('term')])->limit(20)->asArray()->all();
    }
    public function actionShowmonth() {
        /*
        $pmonth = Yii::$app->request->post('pmonth');
        $evpm = \app\models\Event::find()
                ->select(['LEFT(start,10) as day', 'sum(IF((status!=0),0,1)) as evact', 'sum(IF((status!=0),1,0)) as evnoa'])
                ->where('LEFT(start,7) = :cmonth',[':cmonth' => $pmonth])
                ->groupBy(['day'])
                ->asArray()->all();
         * 
         */
        $evpm = $this->search(Yii::$app->request->post());
        return $this->renderPartial('blkdays',['evpm' => $evpm, 'pmonth' => Yii::$app->request->post('pmonth')]);

    }
    public function actionShowday() {
        /*
        $pday = Yii::$app->request->post('pday');
        $evpd = \app\models\Event::find()
                ->where('LEFT(start,10) = :cday',[':cday' => $pday])
                ->orderBy('start')
                ->asArray()->all();
         * 
         */
        $evpd = $this->search(Yii::$app->request->post());
        return $this->renderPartial('blkday',['evpd' => $evpd, 'pday' => Yii::$app->request->post('pday')]);

    }
    public function search($data) {
        //        ->Where(['between','start',$data['start'],$data['end']]);    
        
        $event = \app\models\Event::find();
        switch ($data['acttype']){
            case 'groupmonth':
                $event->select(['LEFT(start,7) as yearmonth', 'sum(IF((status!=0),0,1)) as evact', 'sum(IF((status!=0),1,0)) as evnoa'])
                    ->groupBy(['yearmonth']);
                break;
            case 'groupday':
                $event->select(['LEFT(start,10) as day', 'sum(IF((status!=0),0,1)) as evact', 'sum(IF((status!=0),1,0)) as evnoa'])
                    ->where('LEFT(start,7) = :cmonth',[':cmonth' => $data['actparam']])
                    ->groupBy(['day']);
                break;
            case 'nogroup':
                $event->where('LEFT(start,10) = :cday',[':cday' => $data['actparam']])
                    ->orderBy('start');
                break;
        };
        switch ($data['fltstatus']){
            case 'act':
                $event->andWhere(['status'=>0]);
                break;
            case 'close':
                $event->andWhere(['status'=>1]);
                break;
            case 'overdue':
                $event->andWhere(['status'=>0])->andWhere('start>=:curDate',[':curDate' => date('Y-m-D')]);
                break;
        };
        if($data['flttypes'] != '*') {
            $aTypes = explode(',', $data['flttypes']);
            $event->andWhere(['id_type'=>$aTypes]);
        }
        if (intval($data['fltklient'])==0){
            $isDirector = Yii::$app->user->identity->isDirector;
            $idEmpl = ($isDirector && intval($data['fltempl'])!=0) ? intval($data['fltempl']) : ((!$isDirector) ? Yii::$app->user->id : 0);
            if ($idEmpl!=0){
                $event->leftJoin('kagent','kagent.id=event.id_klient')
                    ->andFilterWhere(['kagent.userId'=>$idEmpl])
                    ->with('kagent');
            }
        }else{
            $event->andWhere(['id_klient'=>$data['fltklient']]);
        }
        
        return $event->asArray()->all();
        
    }
    public function searchv2($emplid) {
        $event = \app\models\Event::find()
            ->andWhere(['status'=>0])
            ->leftJoin('kagent','kagent.id=event.id_klient')
            ->andFilterWhere(['kagent.userId'=>$emplid]);
        
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

}
