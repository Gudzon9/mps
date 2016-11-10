<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Addatr;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class EmplController extends Controller
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSal()
    {
        return $this->render('sal');
    }
    public function actionMoff()
    {
        return $this->render('moff');
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    echo 'ok';
                }
                else{
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            else{
                return $this->renderAjax('_form',[
                    'model' => $model,
                ]);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            //var_dump($model->getErrors());
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id=1)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    $this->saveAddAtr($model);
                    echo 'ok';
                }
                else{
                    //var_dump($model->getErrors());
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            else{
                return $this->renderAjax('_form',[
                    'model' => $model,
                ]);
            }
        }
        else{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->saveAddAtr($model);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //var_dump($model->getErrors());
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    public function saveAddAtr($model){
        foreach (Yii::$app->params['aatr'] as $atrKod=>$val){
            $keys = preg_grep("/^".$val['atrName']."_/", array_keys(Yii::$app->request->post()));
            foreach ($keys as $key){
                if (strrpos($key,'new')!=0){
                    $addAtr = new Addatr();
                    $addAtr->content = Yii::$app->request->post($key);
                    $addAtr->tableKod = 1;
                    $addAtr->tableId = $model->id;
                    $addAtr->atrKod = $atrKod;
                    $addAtr->note = Yii::$app->request->post('note_'.$key,'');
                    if (!$addAtr->save()){
                        var_dump($addAtr->getErrors());
                    }                    
                }else{
                    $id = substr(strrchr($key, "_"), 1);
                    $addAtr = Addatr::findOne($id);
                    if ($addAtr->id!=''){
                        if (strrpos($key,'del')!=0){
                            $addAtr->delete();
                        }Else{
                            $addAtr->content = Yii::$app->request->post($key);
                            $addAtr->note = Yii::$app->request->post('note_'.$key,'');
                            if (!$addAtr->save()){
                                var_dump($addAtr->getErrors());
                            }
                        }
                    }
                }
                
            }        
        }
    }
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
