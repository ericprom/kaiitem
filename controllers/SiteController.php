<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UserMaster;
use app\models\Tmtopup;
use app\models\Banks;
use app\models\Accounts;
use app\models\Items;
use app\models\Orders;
use app\models\MoneyTransfers;
use app\models\TrueMoneys;

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
            ]
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionItem()
    {
        return $this->render('item');
    }
    public function actionSearch(){
        return $this->render('search');
    }
    public function actionQuery(){
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
                    (isset(Yii::$app->user->identity->fbid))?$fbid=Yii::$app->user->identity->fbid:$fbid='';
                    switch($options["section"]){
                        case "item":
                            $item = Items::find()->where(['or', ['LIKE','title', $options["keyword"]], ['LIKE','detail', $options["keyword"]]])->andWhere(['and', ['<>','available', 0], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->with('shops')->asArray()->all();
                            $total = Items::find()->where(['or', ['LIKE','title', $options["keyword"]], ['LIKE','detail', $options["keyword"]]])->andWhere(['and', ['<>','available', 0], ['<>', 'status', 0]])->all();
                            $result["data"]["item"] = $item;
                            $result["data"]["total"] = count($total);
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
                    (isset(Yii::$app->user->identity->fbid))?$fbid=Yii::$app->user->identity->fbid:$fbid='';
                    switch($options["section"]){
                        case "profile":
                            $user = UserMaster::find(['fbid'=>$fbid,'status' => 1])->where(['<>', 'status', 0])->one();
                            $result["data"] = ($user)?$user->attributes:null;
                            break;
                        case "store":
                            $user = UserMaster::find()->where(['and', ['=','fbid', $options["store"]], ['<>', 'status', 0]])->one();
                            $result["data"]["profile"] = ($user)?$user->attributes:null;
                            $item = Items::find()->where(['and', ['=','fbid', $user->fbid],['<>','available', 0], ['<>', 'status', 0]])->with('shops')->asArray()->all();
                            $result["data"]["items"] = $item;
                            break;
                        case "tmtopup":
                            $topup = Tmtopup::find(['fbid'=>$fbid])->one();
                            $result["data"] = ($topup)?$topup->attributes:null;
                            break;
                        case "bank":
                            $bank = Banks::find(['status' => 1])->where(['<>', 'status', 0])->asArray()->all();
                            $result["data"] = $bank;
                            break;
                        case "account":
                            $account = Accounts::find(['fbid'=>$fbid,'status' => 1])->where(['<>', 'status', 0])->with('banks')->asArray()->all();
                            $result["data"] = $account;
                            break;
                        case "item":
                            $item = Items::find()->where(['and', ['<>','available', 0], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->with('shops')->asArray()->all();
                            $total = Items::find()->where(['and', ['<>','available', 0], ['<>', 'status', 0]])->all();
                            $result["data"]["item"] = $item;
                            $result["data"]["total"] = count($total);
                            break;
                        case "detail":
                            $item = Items::find()->where(['and', ['=','id', $options["item"]], ['<>', 'status', 0]])->with('shops')->asArray()->all();
                            $result["data"] = $item;
                            break;
                        case "checkout":
                            $order = Orders::find()->where(['and', ['=','id', $options["order"]], ['<>', 'status', 0]])->with(['items','shops','accounts','tmtopup'])->asArray()->all();
                            $result["data"] = $order;
                            break;
                        case "stock":
                            $item = Items::find(['fbid'=>$fbid,'status' => 1])->where(['<>', 'status', 0])->with('shops')->asArray()->all();
                            $result["data"] = $item;
                            break;
                        case "order":
                            switch ($options["action"]) {
                                case 'purchase':
                                    $purchase = Orders::find()->where(['and', ['=','buyer_id', $fbid], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->with(['items','shops'])->asArray()->all();
                                    $total_purchase = Orders::find()->where(['and', ['=','buyer_id', $fbid], ['<>', 'status', 0]])->all();
                                    $result["data"]["purchase"] = $purchase;
                                    $result["data"]["total_purchase"] = count($total_purchase);
                                    break;
                                case 'sale':
                                    $sale = Orders::find()->where(['and', ['=','shop_id', $fbid], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->with(['items'])->asArray()->all();
                                    $total_sale = Orders::find()->where(['and', ['=','shop_id', $fbid], ['<>', 'status', 0]])->all();
                                    $result["data"]["sale"] = $sale;
                                    $result["data"]["total_sale"] = count($total_sale);
                                    break;
                            }
                            break;
                        case "money":
                            switch ($options["action"]) {
                                case 'transfer':
                                    $transfer = MoneyTransfers::find()->where(['and', ['=','payer_id', $fbid], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->with(['accounts'])->asArray()->all();
                                    $total_transfer = MoneyTransfers::find()->where(['and', ['=','payer_id', $fbid], ['<>', 'status', 0]])->all();
                                    $result["data"]["transfer"] = $transfer;
                                    $result["data"]["total_transfer"] = count($total_transfer);
                                    break;
                                case 'notify':
                                    $notify = MoneyTransfers::find()->where(['and', ['=','shop_id', $fbid], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->with(['accounts'])->asArray()->all();
                                    $total_notify = MoneyTransfers::find()->where(['and', ['=','shop_id', $fbid], ['<>', 'status', 0]])->all();
                                    $result["data"]["notify"] = $notify;
                                    $result["data"]["total_notify"] = count($total_notify);
                                    break;
                            }
                            break;
                        case "true":
                            switch ($options["action"]) {
                                case 'topup':
                                    $topup = TrueMoneys::find()->where(['and', ['=','payer_id', $fbid], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->asArray()->all();
                                    $total_topup = TrueMoneys::find()->where(['and', ['=','payer_id', $fbid], ['<>', 'status', 0]])->all();
                                    $result["data"]["topup"] = $topup;
                                    $result["data"]["total_topup"] = count($total_topup);
                                    break;
                                case 'money':
                                    $money = TrueMoneys::find()->where(['and', ['=','shop_id', $fbid], ['<>', 'status', 0]])->limit($options["limit"])->offset($options["skip"])->asArray()->all();
                                    $total_money = TrueMoneys::find()->where(['and', ['=','shop_id', $fbid], ['<>', 'status', 0]])->all();
                                    $result["data"]["money"] = $money;
                                    $result["data"]["total_money"] = count($total_money);
                                    break;
                            }
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

        $transaction=Yii::$app->db->beginTransaction();
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
                            (isset($data["ref1"]))?$topup->ref1 = $data["ref1"]:$topup->ref1 = '';
                            (isset($data["ref2"]))?$topup->ref2 = $data["ref2"]:$topup->ref2 = '';
                            (isset($data["ref3"]))?$topup->ref3 = $data["ref3"]:$topup->ref3 = '';
                            $topup->created_on = time();
                            $topup->save();
                            $result["data"] = $topup->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
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
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "item":
                            $item = new Items();
                            $item->fbid = $fbid;
                            (isset($data["title"]))?$item->title = $data["title"]:$item->title = '';
                            (isset($data["detail"]))?$item->detail = $data["detail"]:$item->detail = '';
                            (isset($data["quantity"]))?$item->quantity = (int)$data["quantity"]:$item->quantity = '';
                            (isset($data["online_price"]))?$item->online_price = (float)$data["online_price"]:$item->online_price = '';
                            (isset($data["transfer_price"]))?$item->transfer_price = (float)$data["transfer_price"]:$item->transfer_price = '';
                            (isset($data["thumb"]))?$item->thumb = $data["thumb"]:$item->thumb = '';
                            (isset($data["youtube"]))?$item->youtube = $data["youtube"]:$item->youtube = '';
                            $item->available = 1;
                            $item->liked = 0;
                            $item->seen = 0;
                            $item->status = 1;
                            $item->created_on = time();
                            $item->save();
                            $result["data"] = $item->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "order":
                            $order = new Orders();
                            $order->buyer_id = $fbid;
                            (isset($data["id"]))?$order->item_id = $data["id"]:$order->item_id = '';
                            (isset($data["amount"]))?$order->amount = (int)$data["amount"]:$order->amount = '';
                            (isset($data["fbid"]))?$order->shop_id = $data["fbid"]:$order->shop_id = '';
                            $order->created_on = time();
                            $order->status = 1;
                            $order->save();
                            $result["data"] = $order->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "ระบบบันทึกข้อมูลการซื้อแล้ว";
                            break;
                        case "transfer":
                            $transfer = new MoneyTransfer();
                            $transfer->payer_id = $fbid;
                            (isset($data["order_id"]))?$transfer->order_id = $data["order_id"]:$transfer->order_id = '';
                            (isset($data["account_id"]))?$transfer->account_id = $data["account_id"]:$transfer->account_id = '';
                            (isset($data["shop_id"]))?$transfer->shop_id = $data["shop_id"]:$transfer->shop_id = '';
                            (isset($data["transfer_amount"]))?$transfer->transfer_amount = (float)$data["transfer_amount"]:$transfer->transfer_amount = '';
                            (isset($data["transfer_date"]))?$transfer->transfer_date = $data["transfer_date"]:$transfer->transfer_date = '';
                            (isset($data["transfer_time"]))?$transfer->transfer_time = $data["transfer_time"]:$transfer->transfer_time = '';
                            $transfer->created_on = time();
                            $transfer->status = 1;
                            $transfer->save();
                            $result["data"] = $transfer->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "ระบบบันทึกข้อมูลการแจ้งโอนเงินแล้ว";
                            break;
                        case "topup":
                            $truemoney = new TrueMoneys();
                            $truemoney->payer_id = $fbid;
                            (isset($data["order_id"]))?$truemoney->order_id = $data["order_id"]:$truemoney->order_id = '';
                            (isset($data["tmt_id"]))?$truemoney->tmt_id = $data["tmt_id"]:$truemoney->tmt_id = '';
                            (isset($data["shop_id"]))?$truemoney->shop_id = $data["shop_id"]:$truemoney->shop_id = '';
                            (isset($data["cash_card"]))?$truemoney->cash_card = $data["cash_card"]:$truemoney->cash_card = '';
                            $truemoney->created_on = time();
                            $truemoney->status = 1;
                            $truemoney->save();
                            $result["data"] = $truemoney->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "ระบบบันทึกข้อมูลการแจ้งโอนเงินแล้ว";
                            break;
                    }
                    $transaction->commit();
                }
            } catch(Exceptions $ex) {
                $result["status"] = FALSE;
                $result["toast"] = 'warning';
                $result["error"] = $ex;
                $result["message"] =  "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
                $transaction->rollback();
            }
            echo json_encode($result);
        }
    }
    public function actionUpdate()
    {
        $transaction=Yii::$app->db->beginTransaction();
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
                            (isset($data["ref1"]))?$topup->ref1 = $data["ref1"]:$topup->ref1 = '';
                            (isset($data["ref2"]))?$topup->ref2 = $data["ref2"]:$topup->ref2 = '';
                            (isset($data["ref3"]))?$topup->ref3 = $data["ref3"]:$topup->ref3 = '';
                            $topup->updated_on = time();
                            $topup->update();
                            $result["data"] = $topup->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;

                        case "profile":
                            $user = UserMaster::findOne(['fbid'=>$fbid]);
                            (isset($data["username"]))?$user->username = $data["username"]:$user->username = '';
                            (isset($data["email"]))?$user->email = $data["email"]:$user->email = '';
                            (isset($data["phone"]))?$user->phone = $data["phone"]:$user->phone = '';
                            (isset($data["location"]))?$user->location = $data["location"]:$user->location = '';
                            (isset($data["bio"]))?$user->bio = $data["bio"]:$user->bio = '';
                            $user->updated_on = time();
                            $user->update();
                            $result["data"] = $user->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "online":
                            $user = UserMaster::findOne(['fbid'=>$fbid]);
                            (isset($data["action"]))?$user->online = $data["action"]:$user->online = '';
                            $user->updated_on = time();
                            $user->update();
                            $result["data"] = $user->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "account":
                            $account = Accounts::findOne(['id'=>$data["id"]]);
                            $account->fbid = $fbid;
                            (isset($data["account"]["id"]))?$account->bank_id = $data["account"]["id"]:$account->bank_id = '';
                            (isset($data["name"]))?$account->name = $data["name"]:$account->name = '';
                            (isset($data["number"]))?$account->number = $data["number"]:$account->number = '';
                            $account->updated_on = time();
                            $account->update();
                            $result["data"] = $data;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "item":
                            $item = Items::findOne(['fbid'=>$fbid, 'id'=> $data["id"]]);
                            (isset($data["title"]))?$item->title = $data["title"]:$item->title = '';
                            (isset($data["detail"]))?$item->detail = $data["detail"]:$item->detail = '';
                            (isset($data["quantity"]))?$item->quantity = (int)$data["quantity"]:$item->quantity = '';
                            (isset($data["online_price"]))?$item->online_price = (float)$data["online_price"]:$item->online_price = '';
                            (isset($data["transfer_price"]))?$item->transfer_price = (float)$data["transfer_price"]:$item->transfer_price = '';
                            (isset($data["thumb"]))?$item->thumb = $data["thumb"]:$item->thumb = '';
                            (isset($data["youtube"]))?$item->youtube = $data["youtube"]:$item->youtube = '';
                            $item->updated_on = time();
                            $item->update();
                            $result["data"] = $item->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "order":
                            $order = Orders::findOne(['buyer_id'=>$fbid, 'id'=> $data["id"]]);
                            (isset($data["amount"]))?$order->amount = (int)$data["amount"]:$item->amount = '';
                            $order->updated_on = time();
                            $order->update();
                            $result["data"] = $order->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            break;
                        case "available":
                            $item = Items::findOne(['fbid'=>$fbid, 'id'=> $data["id"]]);
                            (isset($data["available"]))?$item->available = $data["available"]:$item->available = '';
                            $item->updated_on = time();
                            $item->update();
                            $result["data"] = $item->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            if($data["available"]==1){
                                $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            }
                            else{
                                $result["message"] =  "บันทึกข้อมูลเรียบร้อย";
                            }
                            break;

                        case "transfer":
                            $transfer = MoneyTransfers::findOne(['shop_id'=>$fbid, 'id'=> $data["id"]]);

                            switch ($options["action"]) {
                                case 'accept':
                                    $transfer->status =2;
                                    $result["message"] =  "ยืนยันได้รับเงินแล้ว";
                                    break;
                                case 'fraud':
                                    $transfer->status = 3;
                                    $result["message"] =  "ยังไม่ได้รับเงิน";
                                    break;
                            }
                            $transfer->updated_on = time();
                            $transfer->update();
                            $result["data"] = $transfer->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            break;
                        case "topup":
                            $topup = TrueMoneys::findOne(['shop_id'=>$fbid, 'id'=> $data["id"]]);

                            switch ($options["action"]) {
                                case 'accept':
                                    $topup->status =2;
                                    $result["message"] =  "ผ่านการอนุมัติ";
                                    break;
                                case 'fraud':
                                    $topup->status = 3;
                                    $result["message"] =  "ยังไม่ผ่านการอนุมัติ";
                                    break;
                            }
                            $topup->updated_on = time();
                            $topup->update();
                            $result["data"] = $topup->attributes;
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            break;
                    }
                    $transaction->commit();
                }
            } catch(Exceptions $ex) {
                $result["status"] = FALSE;
                $result["toast"] = 'warning';
                $result["error"] = $ex;
                $result["message"] =  "เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้";
                $transaction->rollback();
            }
            echo json_encode($result);
        }
    }
    public function actionDelete()
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
                        case "user":
                            $user = UserMaster::findOne(['fbid'=>$fbid,'status' => 1]);
                            $user->online = 0;
                            $user->status = 0;
                            $user->updated_on = time();
                            $user->update();
                            $result["data"] = $user->attributes;
                            break;
                        case "account":
                            $account = Accounts::findOne(['id'=> $data["id"]]);
                            $account->status = 0;
                            $account->updated_on = time();
                            $account->update();
                            $result["data"] = $account->attributes;
                            break;
                        case "item":
                            $item = Items::findOne(['id'=> $data["id"]]);
                            $item->status = 0;
                            $item->updated_on = time();
                            $item->update();
                            $result["data"] = $item->attributes;
                            break;
                        case "order":
                            $item = Orders::findOne(['id'=> $data["id"]]);
                            $item->status = 0;
                            $item->updated_on = time();
                            $item->update();
                            $result["data"] = $item->attributes;
                            break;
                    }
                    $result["toast"] = 'success';
                    $result["status"] = TRUE;
                    $result["message"] =  "ลบข้อมูลเรียบร้อย";
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
        if(!Yii::$app->user->isGuest){
            return $this->render('store');
        }
        else{
            return $this->goHome();
        }
    }
    public function actionCheckout(){
        if(!Yii::$app->user->isGuest){
            $request = Yii::$app->request;
            $id = $request->get('id');
            $order = Orders::find()->where(['id' => $id])->one();
            $shopID = null;
            if($order){
                $shopID = $order->shop_id;
            }
            $tmt = Tmtopup::find()->where(['fbid' => $shopID])->one();
            return $this->render('checkout', [
                'tmtopup' => $tmt,
                'order' => $order
            ]);
        }
        else{
            return $this->goHome();
        }
    }
    public function actionProfile()
    {
        if(!Yii::$app->user->isGuest){
            return $this->render('profile');
        }
        else{
            return $this->goHome();
        }
    }
    public function actionSetting()
    {
        if(!Yii::$app->user->isGuest){
            return $this->render('setting');
        }
        else{
            return $this->goHome();
        }
    }
    public function actionStock()
    {
        if(!Yii::$app->user->isGuest){
            return $this->render('stock');
        }
        else{
            return $this->goHome();
        }
    }
    public function actionOrder()
    {
        if(!Yii::$app->user->isGuest){
            return $this->render('order');
        }
        else{
            return $this->goHome();
        }
    }
    public function actionPayment()
    {
        if(!Yii::$app->user->isGuest){
            return $this->render('payment');
        }
        else{
            return $this->goHome();
        }
    }
    public function onAuthSuccess($client)
    {
        $userAttributes = $client->getUserAttributes();
        $fbid = $userAttributes['id'];
        $fbname = $userAttributes['name'];
        $fbemail = $userAttributes['email'];

        $user = UserMaster::find()->where(['fbid' => $fbid])->one();

        if(empty($user)){
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
    public function actionMark()
    {
        if(!Yii::$app->user->isGuest){
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
                            case "item":
                                $item = Items::findOne(['id'=> $data["id"]]);
                                $item->seen += 1;
                                $item->update();
                                $result["data"] = $item->attributes;
                                break;
                        }
                        $result["toast"] = 'success';
                        $result["status"] = TRUE;
                        $result["message"] =  "นับสถิติข้อมูลเรียบร้อย";
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
    }
    public function actionMail()
    {
        if(!Yii::$app->user->isGuest){
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
                        $email = Yii::$app->user->identity->email;
                        if($email != null){
                            switch($options["section"]){
                                case "email":
                                    Yii::$app->mailer->compose()
                                    ->setFrom('support@kaiitem.com')
                                    ->setTo($data['email'])
                                    ->setSubject($data['topic'])
                                    ->setTextBody($data['body'])
                                    // ->setHtmlBody('<b>HTML content</b>')
                                    ->send();
                                    break;
                            }
                            $result["toast"] = 'success';
                            $result["status"] = TRUE;
                            $result["message"] =  "ส่งอีเมล์ถึงร้านค้าแล้ว";
                        }
                        else{
                            $result["toast"] = 'warning';
                            $result["status"] = FALSE;
                            $result["message"] =  "กรุณาอัพเดทอีเมล์";
                        }
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
    }
}
