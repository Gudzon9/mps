<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class EmplController extends Controller
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
        return $this->render('index');
    }
    public function actionSal()
    {
        return $this->render('sal');
    }
    public function actionMoff()
    {
        return $this->render('moff');
    }


}
