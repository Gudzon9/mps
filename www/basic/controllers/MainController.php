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
        return $this->render('index');
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


}
