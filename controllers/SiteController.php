<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UserMaster;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUpdate()
    {
        $param = array("filter"=>FALSE);
        foreach ($param as $key => $val) {
            if (isset($_REQUEST[$key])) {
                $param[$key] = $_REQUEST[$key];
            }
        }
        $result = array("status" => FALSE, "data" => "");
        try {
            $options = array();
            if (is_array($param["filter"]) ) {
                $options = $param["filter"];
                if (gettype($options["data"]) == "string") {
                    $data = json_decode($options["data"], TRUE);

                } else {
                    $data = json_encode($options["data"]);
                    $data = json_decode($data, TRUE);
                }
                $result["data"] = $data;
                $result["status"] = TRUE;
            }
        } catch(Exceptions $ex) {
            $result["status"] = FALSE;
            $result["error"] = $ex;
            $result["message"] =  "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
        }
        echo json_encode($result);
    }

    public function actionStore()
    { 
        return $this->render('store');
    }
    public function actionCheckout(){
        return $this->render('checkout');
    }
    public function actionProfile()
    {
        return $this->render('profile');
    }
    public function actionSetting()
    {
        //$user = UserMaster::find()->where(['fbid' => Yii::$app->user->identity->fbid])->one();
        //if ($user->load(Yii::$app->request->post())) {
            // return $this->redirect(['setting', 'id' => $user->id]);
            // if($user->save()){
            //     //echo 1;
            // }
            // else{
            //     echo 0;
            // }
        //} else {
            //return $this->render('setting', ['user' => $user]);
        //}
        return $this->render('setting');
    }
    
    public function onAuthSuccess($client)
    {
        $userAttributes = $client->getUserAttributes();
        $fbid = $userAttributes['id'];
        $fbname = $userAttributes['name'];
        $fbemail = $userAttributes['email'];

        $user = UserMaster::find()->where(['fbid' => $fbid])->one();

        if(empty($user))    {
            $user = new UserMaster();
            $user->fbid = $fbid;
            $user->created_on = time();
        }
        $model = new LoginForm();
        $model->username = (string)$user->fbid;
        if($user->isNewRecord) {
            $user->name = $fbname;
            $user->email = $fbemail;
        }
        else{
            $user->name = $fbname;
            $user->updated_on = time();
            $user->auth_key = $user->generateAuthKey();
        }
        $user->save();
        $model->login();
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
