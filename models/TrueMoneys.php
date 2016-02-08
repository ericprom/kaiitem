<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "true_moneys".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $tmt_id
 * @property string $cash_card
 * @property string $payer_id
 * @property string $shop_id
 * @property double $created_on
 * @property double $updated_on
 * @property integer $status
 */
class TrueMoneys extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'true_moneys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['order_id', 'tmt_id', 'cash_card', 'payer_id', 'shop_id', 'created_on', 'updated_on'], 'required'],
            [['order_id', 'tmt_id', 'status'], 'integer'],
            [['created_on', 'updated_on'], 'number'],
            [['cash_card'], 'string', 'max' => 14],
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
            'tmt_id' => 'Tmt ID',
            'cash_card' => 'Cash Card',
            'payer_id' => 'Payer ID',
            'shop_id' => 'Shop ID',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'status' => 'Status',
        ];
    }
}
