<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

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
         * 
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
