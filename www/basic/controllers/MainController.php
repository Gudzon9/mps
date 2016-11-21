<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models;

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
        /*
                ->where('LEFT(start,7) != :cmonth',[':cmonth' => $cmonth])
                ->where('LEFT(start,10) != :cday ',[':cday' => $cday])
        
         */
        $cmonth =  substr(date('Y-m-d'),0,7);
        $evoldm = \app\models\Event::find()
                ->select(['LEFT(start,7) as yearmonth', 'sum(IF((status!=0),0,1)) as evact', 'sum(IF((status!=0),1,0)) as evnoa'])
                ->groupBy(['yearmonth'])
                ->asArray()->all();

        $cday =  date('Y-m-d');
        $evcurm = \app\models\Event::find()
                ->select(['LEFT(start,10) as day', 'sum(IF((status!=0),0,1)) as evact', 'sum(IF((status!=0),1,0)) as evnoa'])
                ->andWhere('LEFT(start,7) = :cmonth',[':cmonth' => $cmonth])
                ->groupBy(['day'])
                ->asArray()->all();

        $evcurd = \app\models\Event::find()
                ->where('LEFT(start,10) = :cday',[':cday' => $cday])
                ->orderBy('start')
                ->asArray()->all();
        return $this->render('index',
            ['cmonth' => $cmonth,'evoldm' => $evoldm,'cday' => $cday,'evcurm' => $evcurm,'evcurd' => $evcurd]);
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
            $isDirector = Yii::$app->session->get('isDirector');
            $idEmpl = ($isDirector && intval($post['fltempl'])!=0) ? intval($post['fltempl']) : ((!$isDirector) ? Yii::$app->user->id : 0);
            if ($idEmpl!=0){
                $event->leftJoin('kagent','kagent.id=event.id_klient')
                    ->andFilterWhere(['kagent.userId'=>$idEmpl])
                    ->with('kagent');
            }
        }else{
            $event->andWhere(['id_klient'=>$post['fltklient']]);
        }
        
        return $event->asArray()->all();
                
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
    }
    public function actionShowmonth() {
        $pmonth = Yii::$app->request->post('pmonth');
        $evpm = \app\models\Event::find()
                ->select(['LEFT(start,10) as day', 'sum(IF((status!=0),0,1)) as evact', 'sum(IF((status!=0),1,0)) as evnoa'])
                ->where('LEFT(start,7) = :cmonth',[':cmonth' => $pmonth])
                ->groupBy(['day'])
                ->asArray()->all();
        return $this->renderPartial('blkdays',['evpm' => $evpm, 'pmonth' => $pmonth]);

    }
    public function actionShowday() {
        $pday = Yii::$app->request->post('pday');
        $evpd = \app\models\Event::find()
                ->where('LEFT(start,10) = :cday',[':cday' => $pday])
                ->orderBy('start')
                ->asArray()->all();
        return $this->renderPartial('blkday',['evpd' => $evpd, 'pday' => $pday]);

    }


}
