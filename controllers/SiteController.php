<?php

namespace app\controllers;

use Yii;
use app\commands\JSONUtil;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UserMaster;
use app\models\Tmtopup;
use app\models\Banks;
use app\models\Accounts;

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
    public function actionSelect()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
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
                    $fbid = Yii::$app->user->identity->fbid;
                    switch($options["section"]){
                        case "profile":
                            $user = UserMaster::findOne(['fbid'=>$fbid,'status' => 1]);
                            $result["data"] = ($user)?$user->attributes:null;
                            break;
                        case "tmtopup":
                            $topup = Tmtopup::findOne(['fbid'=>$fbid]);
                            $result["data"] = ($topup)?$topup->attributes:null;
                            break;
                        case "banks":
                            $bank = Banks::findAll(['status' => 1]);
                            $result["data"] = JSONUtil::convertModelToArray($bank);
                            break;
                        case "accounts":
                            $account = Accounts::find(['fbid'=>$fbid,'status' => 1])->with('banks')->asArray()->all();
                            $result["data"] = $account;
                            break;
                    }
                    $result["status"] = TRUE;
                }
            } catch(Exceptions $ex) {
                $result["status"] = FALSE;
                $result["error"] = $ex;
                $result["message"] =  "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
            }
            echo json_encode($result);
        }
    }
    public function actionInsert()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
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
                    $fbid = Yii::$app->user->identity->fbid;
                    switch($options["section"]){
                        case "tmtopup":
                            $topup = new Tmtopup();
                            $topup->fbid = $fbid;
                            (isset($data["uid"]))?$topup->uid = $data["uid"]:$topup->uid = '';
                            (isset($data["ref_1"]))?$topup->ref_1 = $data["ref_1"]:$topup->ref_1 = '';
                            (isset($data["ref_2"]))?$topup->ref_2 = $data["ref_2"]:$topup->ref_2 = '';
                            (isset($data["ref_3"]))?$topup->ref_3 = $data["ref_3"]:$topup->ref_3 = '';
                            (isset($data["passkey"]))?$topup->passkey = $data["passkey"]:$topup->passkey = '';
                            $topup->created_on = time();
                            $topup->save();
                            $result["data"] = $topup->attributes;
                            break;

                        case "account":
                            $account = new Accounts();
                            $account->fbid = $fbid;
                            (isset($data["account"]["id"]))?$account->bank_id = $data["account"]["id"]:$account->bank_id = '';
                            (isset($data["name"]))?$account->name = $data["name"]:$account->name = '';
                            (isset($data["number"]))?$account->number = $data["number"]:$account->number = '';
                            $account->created_on = time();
                            $account->save();
                            $result["data"] = $data;
                            break;
                    }
                    $result["toast"] = 'success';
                    $result["status"] = TRUE;
                    $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                }
            } catch(Exceptions $ex) {
                $result["status"] = FALSE;
                $result["toast"] = 'warning';
                $result["error"] = $ex;
                $result["message"] =  "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
            }
            echo json_encode($result);
        }
    }
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
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
                    $fbid = Yii::$app->user->identity->fbid;
                    switch($options["section"]){
                        case "tmtopup":
                            $topup = Tmtopup::findOne(['fbid'=>$fbid]);
                            (isset($data["uid"]))?$topup->uid = $data["uid"]:$topup->uid = '';
                            (isset($data["ref_1"]))?$topup->ref_1 = $data["ref_1"]:$topup->ref_1 = '';
                            (isset($data["ref_2"]))?$topup->ref_2 = $data["ref_2"]:$topup->ref_2 = '';
                            (isset($data["ref_3"]))?$topup->ref_3 = $data["ref_3"]:$topup->ref_3 = '';
                            (isset($data["passkey"]))?$topup->passkey = $data["passkey"]:$topup->passkey = '';
                            $topup->updated_on = time();
                            $topup->update();
                            $result["data"] = $topup->attributes;
                            break;

                        case "profile":
                            $user = UserMaster::findOne(['fbid'=>$fbid,'status' => 1]);
                            (isset($data["username"]))?$user->username = $data["username"]:$user->username = '';
                            (isset($data["email"]))?$user->email = $data["email"]:$user->email = '';
                            (isset($data["phone"]))?$user->phone = $data["phone"]:$user->phone = '';
                            (isset($data["location"]))?$user->location = $data["location"]:$user->location = '';
                            (isset($data["bio"]))?$user->bio = $data["bio"]:$user->bio = '';
                            $user->updated_on = time();
                            $user->update();
                            $result["data"] = $user->attributes;
                            break;
                    }
                    $result["toast"] = 'success';
                    $result["status"] = TRUE;
                    $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                }
            } catch(Exceptions $ex) {
                $result["status"] = FALSE;
                $result["toast"] = 'warning';
                $result["error"] = $ex;
                $result["message"] =  "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
            }
            echo json_encode($result);
        }
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
