<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $amount
 * @property string $shop_id
 * @property string $buyer_id
 * @property double $created_on
 * @property double $updated_on
 * @property integer $status
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['item_id', 'amount', 'shop_id', 'buyer_id', 'created_on', 'updated_on'], 'required'],
            [['item_id', 'amount', 'status'], 'integer'],
            [['created_on', 'updated_on'], 'number'],
            [['shop_id', 'buyer_id'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'amount' => 'Amount',
            'shop_id' => 'Shop ID',
            'buyer_id' => 'Buyer ID',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'status' => 'Status',
        ];
    }
    public function getItems()
    {
        return $this->hasMany(Items::className(), ['id' => 'item_id']);
    }
    public function getShops()
    {
        return $this->hasMany(UserMaster::className(), ['fbid' => 'shop_id']);
    }
    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['fbid' => 'shop_id'])->with('banks');
    }
    public function getTmtopup()
    {
        return $this->hasMany(Tmtopup::className(), ['fbid' => 'shop_id']);
    }
}
