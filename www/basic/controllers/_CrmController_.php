<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class CrmController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //$dmtest = new \yii\base\Object();
        $dmtest['kod'] = '1'; 
        $dmtest['name'] = 'Pink Floyd';
        return $this->render('index',['items'=>$dmtest,]);
    }
    public function actionComm()
    {
        return $this->render('comm');
    }

    public function actionSends()
    {
        return $this->render('sends');
    }



}
