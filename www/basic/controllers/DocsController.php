<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
//use mihaildev\elfinder\ElFinder;

class DocsController extends Controller
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
        // default see config/web.php
        return $this->render('index',['cn' => 'elfinder']);
    }
    public function actionMng()
    {
        return $this->render('index',['cn' => 'elfinderm']);
         
    }
    public function actionTmp()
    {
        return $this->render('index',['cn' => 'elfindert']);
    }


}
