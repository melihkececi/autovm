<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

use app\models\Vps;
use app\models\Log;
use app\models\VipHosting;
use app\models\Rdns;
use app\modules\admin\filters\OnlyAdminFilter;
use yii\data\ActiveDataProvider;
use app\models\searchs\searchRdnsdata;
use app\models\searchs\searchRdnsdurum;


class RdnsController extends Controller
{
    public function behaviors()
    {
        return [
            OnlyAdminFilter::className(),
        ];
    }

    public function actionIndex()
    {
        $rdns_users = Rdns::find()->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
              'query' => $rdns_users,
              'pagination' => [
                'pageSize' => 10,
              ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
    public function actionData()
    {
        $searchModel = new searchRdnsdata();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('data', [
            'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
	   ]);
    }
	
    public function actionWaitpending()
    {
		
        $searchModel = new searchRdnsdurum();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('waitpending', [
            'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
        ]);
    }
	
	public function actionRdnsGuncelle(){
		return VipHosting::RdnsControllerRdnsGuncelle();
	}
	
	public function actionDataView(){
		$rdnsModuleVipHosting = VipHosting::RdnsControllerDataView();
		if($rdnsModuleVipHosting['ok'] == true){
			return $this->renderAjax('data-edit', $rdnsModuleVipHosting['response']);
		}
		else{
			return $rdnsModuleVipHosting['response'];
		}
	}
	
	public function actionSettings(){
		$rdnsModule = VipHosting::RdnsSettings();
		if(isset($rdnsModule['post'])){
			return $this->refresh();
		}
        return $this->render('settings', $rdnsModule['response']);
	}
	
    public function actionCreate()
    {
		$rdnsModule = VipHosting::RdnsControllerCreateUser();
		if(isset($rdnsModule['post'])){
			return $this->refresh();
		}
        return $this->render('create', $rdnsModule['response']);
    }
	
    public function actionEdit($id)
    {
		$rdnsModule = VipHosting::RdnsControllerEditUser($id);
		if(isset($rdnsModule['post'])){
			return $this->refresh();
		}
        return $this->render('edit', $rdnsModule['response']);
    }
	
    public function actionDelete()
    {
		VipHosting::RdnsControllerDeleteUser();
        return $this->redirect(Yii::$app->request->referrer);
    }
	
	public function actionDeleteData(){
		VipHosting::RdnsControllerDeleteData();
        return $this->redirect(Yii::$app->request->referrer);
	}
	
	public function actionDeletePending(){
		VipHosting::RdnsControllerDeletePending();
        return $this->redirect(Yii::$app->request->referrer);
	}
	

}
