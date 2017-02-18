<?php

namespace app\controllers;

use Yii;
use app\models\Ui;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TmcController implements the CRUD actions for Tmc model.
 */
class UiController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionApply()
    {
        $varPost = Yii::$app->request->post();
        $user_id = Yii::$app->user->identity->id;
        foreach ($varPost["colInf"] as $ColInf){
            $ui = Ui::findOne(['user_id'=>$user_id, 'model'=>$varPost['modelName'], 'attribute'=>$ColInf['attr']]);
            if (!is_object($ui)){
                $ui = new ui();
                $ui->user_id=$user_id;
                $ui->model = $varPost['modelName'];
                $ui->attribute = $ColInf['attr'];
            }
            $ui->value = $ColInf['val'];
            $ui->save();
        }
    }
}
