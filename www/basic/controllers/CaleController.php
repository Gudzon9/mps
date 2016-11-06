<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Event;

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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetevents()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //return 'ss5566';
        //Yii::$app->response->format = Response::FORMAT_JSON;
        
        //if (!Yii::$app->request->isAjax || Yii::$app->user->isGuest){
            //return $this->goHome();
        //}
        //$event = Yii::$app->db->createCommand('SELECT * FROM event')->queryAll();
        //$event = Event::find();
        //$event = $event->andWhere(['status'=>1]);
        //return $event->asArray()->all();
        
        $status = Yii::$app->request->post('fltstatus');
        $post = Yii::$app->request->post();
        $event = Event::find()
                ->andWhere(['between','start',Yii::$app->request->post('start'),Yii::$app->request->post('end')])
                ->andFilterWhere(['id_klient'=>Yii::$app->request->post('fltklient')])
                ;
        /*
        switch ($status){
            case 'act':
                $event = $event->andWhere(['status'=>0]);
                break;
            case 'close':
                $event = $event->andWhere(['status'=>1]);
                break;
            case 'overdue':
                $event = $event->andWhere(['status'=>0])->andWhere('start>=:curDate',[':curDate' => date('Y-m-D')]);
                break;
        };
        */
        $aTypes = explode(',', Yii::$app->request->post('flttypes'));
        $event->andWhere(['id_type'=>$aTypes]) ;
        $fltempl = Yii::$app->request->post('fltempl');
        if(!empty($fltempl)){
        $event = $event->with('kagent')
                ->leftJoin('kagent','kagent.id=event.id_klient')
                ->andFilterWhere(['kagent.userId'=>$fltempl]);
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
           */ 
        
    }
    public function actionSearchempl()
    {
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
        /*  По $_POST[] переменные :
         *  id = 0,start,end,color,allDay,type,id_type,klient,id_klient,prim,status
         *  поле title = type + klient + prim 
         * 
         * ответ значение id  (если неусп.добавлен. -  id = 0)
         */
    }
    public function actionEditevent()
    {
        /*
         * аналогично  actionAddevent - только id != 0  
         */
    }
        
}
