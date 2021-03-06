<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models;
use yii\filters\AccessControl;

class CaleController extends Controller
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
        $events = $this->searchevents($fltuserId,'allevents');
        $top = 'top';

        return $this->render('index',[
            'events' => $events,
            'top' => $top,
            ]);
    }

    public function actionGetevents()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                
        $post = Yii::$app->request->post();        
        $status = $post['fltstatus'];
        $event = \app\models\Event::find()
                ->Where(['between','start',$post['start'],$post['end']]);
        switch ($status){
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
        $aTypes = explode(',', $post['flttypes']);
        $event->andWhere(['id_type'=>$aTypes]);
        if (intval($post['fltklient'])==0){
            $isDirector = \Yii::$app->user->identity->isDirector;
            $idEmpl = ($isDirector && intval($post['fltempl'])!=0) ? intval($post['fltempl']) : ((!$isDirector || Yii::$app->session->get('allkag')==1) ? \Yii::$app->user->identity->id : 0);
            
            if ($idEmpl!=0){
                
                $event->leftJoin('kagent','kagent.id=event.id_klient')
                    ->andFilterWhere(['kagent.userId'=>$idEmpl]);
                    //->with('kagent');
                
                //var_dump($event->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
                //return ;
            }
        }else{
            $event->andWhere(['id_klient'=>$post['fltklient']]);
        }
        
        return $event->asArray()->all();
                
        /*  Список событий по фильтрам
         *  $_POST['start'], $_POST['end'] - диапазон для поля 'start'
         *  $_POST['fltempl'] - id менеджера (устан.на клиенте)
         *      - для isDirector = true : id = 0 - все , id != 0 - только один менедж. 
         *      - для isDirector = false : всегда id залогиненного менедж. 
         *  $_POST['fltklient'] - id клиента (id = 0 - все) поле 'id_klient'
         *  $_POST['fltstatus'] - по состоянию события 
         *       - all => Все
         *       - act => Активные (status = 0)
         *       - close => Закрытые (status = 1)
         *       - overdue => Просроченные (status = 0 AND start >= текущий момент)
         *  $_POST['flttypes'] - строка типа "1,3,4" - надо распарсить в массив 
         *                      допустимых значений для поля 'id_type' 
         * 
         * 
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            [    
                'id' => '1',
                'start' => '2016-11-02 10:00:00+00:00',
                'end' => '2016-11-02 10:30:00+00:00',
	                'allDay' => true,
                'title' => 'prim',
                'type' => 'call',
                'id_type' => '1',
                'klient' => 'klient',
                'id_klient' => '1',
                'prim' => 'prim',
                'color' => 'color',
                'status' => '0',
            ],    
        ];        
         * 
         */
    }
    public function actionSearchempl()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $get = Yii::$app->request->get();
        $aEmpl = \app\models\User::find()->Where(['like','fio',$get['term']])->limit(20)->all();
        foreach ( $aEmpl as $oEmpl){
            $aRet[] = array('id'=>$oEmpl->id,'value'=>$oEmpl->fio);
        }
        return $aRet;
        
        /* поиск по менеджерам (по назв)
         * в $_GET['term'] - набранные символы
         * 
         * ответ JSON не более 20 строк
         * пример :  return [
         *              ['id' => 1, 'value' => 'qwerty'],
         *              ['id' => 2, 'value' => 'yuiopui'], 
         *              .... 
         *          ]
         */
        
    }
    public function actionSearchklient()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $get = Yii::$app->request->get();
        $aKagent = \app\models\Kagent::find()->Where(['like','name',$get['term']])->limit(20)->all();
        foreach ( $aKagent as $oKagent){
            $aRet[] = array('id'=>$oKagent->id,'value'=>$oKagent->name);
        }
        return $aRet;        
        /* поиск по клиентам (по назв)
         * в $_GET['term'] - набранные символы
         * 
         * ответ JSON не более 20 строк
         * пример :  return [
         *              ['id' => 1, 'value' => 'qwerty'],
         *              ['id' => 2, 'value' => 'yuiopui'], 
         *              .... 
         *          ]
         */
        
    }
    public function actionAddevent()
    {
        $model = new \app\models\Event();
        $aRec['Event']=Yii::$app->request->post();
        if ($model->load($aRec)) {
            if (!$model->save()){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $model->getErrors();
            }
        }
    }
        /*  По $_POST[] переменные :
         *  id = 0,start,end,color,allDay,type,id_type,klient,id_klient,prim,status
         *  поле title = type + klient + prim 
         * 
         * ответ значение id  (если неусп.добавлен. -  id = 0)
         */
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
        /*
         * аналогично  actionAddevent - только id != 0  
         */
    }  
    public function actionGetevwflt()
    {
        if(!Yii::$app->user->identity->isDirector || Yii::$app->session->get('allkag')==1) {
            $fltuserId = Yii::$app->user->identity->id;   
        } else {$fltuserId = NULL;}
        $flt = Yii::$app->request->post('pflt');
        $fdate = Yii::$app->request->post('pfdate');
        $top = Yii::$app->request->post('ptop');
        //$events = $this->searchv2($fltuserId,$sparam,$top);
        
        $events = $this->searchevents($fltuserId,$flt,$fdate);
        
        return $this->renderFile(Yii::getAlias('@app/views/main/tblevent.php'),['events' => $events,'top' => $top]); 
    } 
    public function searchevents($emplid=NULL,$flt,$fdate=NULL) {
        $event = \app\models\Event::find()
            ->orderBy(['start'=>SORT_DESC])
            ->andWhere(['status'=>0])
            ->leftJoin('kagent','kagent.id=event.id_klient')
            ->andFilterWhere(['kagent.userId'=>$emplid]);
        switch ($flt){
            case 'allevents':
                //$event->andWhere('LEFT(start,10) < :curDate',[':curDate' => $today]);
                break;
            case 'dayevents':
                $event->andWhere('LEFT(start,10) = :curDate',[':curDate' => $fdate]);
                break;
            case 'weekevents':
                $today =  date('Y-m-d',strtotime($fdate));
                $last_Monday = date("Y-m-d",strtotime("last Monday of $today"));
                $end_week = date("Y-m-d",strtotime("$last_Monday + 7 day"));
                
                $event->andWhere('LEFT(start,10) >= :begDate',[':begDate' => $last_Monday])
                    ->andWhere('LEFT(start,10) <= :endDate',[':endDate' => $end_week]);
                break;
        };
        
        return $event->asArray()->all();
    }
    
}
