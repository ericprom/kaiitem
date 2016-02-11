<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money_transfers".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $account_id
 * @property double $transfer_amount
 * @property double $transfer_date
 * @property string $transfer_time
 * @property string $payer_id
 * @property string $shop_id
 * @property double $created_on
 * @property double $updated_on
 * @property integer $status
 */
class MoneyTransfers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money_transfers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['order_id', 'account_id', 'transfer_amount', 'transfer_date', 'transfer_time', 'payer_id', 'shop_id', 'created_on', 'updated_on'], 'required'],
            [['order_id', 'account_id', 'status'], 'integer'],
            [['transfer_amount', 'transfer_date', 'created_on', 'updated_on'], 'number'],
            [['transfer_time'], 'string', 'max' => 10],
            [['payer_id', 'shop_id'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'account_id' => 'Account ID',
            'transfer_amount' => 'Transfer Amount',
            'transfer_date' => 'Transfer Date',
            'transfer_time' => 'Transfer Time',
            'payer_id' => 'Payer ID',
            'shop_id' => 'Shop ID',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'status' => 'Status',
        ];
    }
    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['id' => 'account_id'])->with('banks');
    }
}
