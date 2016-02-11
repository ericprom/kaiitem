<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $title
 * @property string $detail
 * @property string $thumb
 * @property string $youtube
 * @property integer $quantity
 * @property double $online_price
 * @property double $transfer_price
 * @property integer $seen
 * @property integer $liked
 * @property integer $available
 * @property string $fbid
 * @property double $created_on
 * @property double $updated_on
 * @property integer $status
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['title', 'detail', 'thumb', 'youtube', 'quantity', 'online_price', 'transfer_price', 'fbid', 'created_on', 'updated_on'], 'required'],
            [['detail', 'thumb'], 'string'],
            [['quantity', 'seen', 'liked', 'available', 'status'], 'integer'],
            [['online_price', 'transfer_price', 'created_on', 'updated_on'], 'number'],
            [['title'], 'string', 'max' => 80],
            [['youtube'], 'string', 'max' => 255],
            [['fbid'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'detail' => 'Detail',
            'thumb' => 'Thumb',
            'youtube' => 'Youtube',
            'quantity' => 'Quantity',
            'online_price' => 'Online Price',
            'transfer_price' => 'Transfer Price',
            'seen' => 'Seen',
            'liked' => 'Liked',
            'available' => 'Available',
            'fbid' => 'Fbid',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'status' => 'Status',
        ];
    }
    public function getShops()
    {
        return $this->hasMany(UserMaster::className(), ['fbid' => 'fbid']);
    }
}
