<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property integer $bank_id
 * @property string $name
 * @property string $number
 * @property string $fbid
 * @property integer $status
 * @property double $created_on
 * @property double $updated_on
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['bank_id', 'name', 'number', 'fbid', 'created_on', 'updated_on'], 'required'],
            [['bank_id', 'status'], 'integer'],
            [['created_on', 'updated_on'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['number'], 'string', 'max' => 15],
            [['fbid'], 'string', 'max' => 30]
        ];
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_id' => 'Bank ID',
            'name' => 'Name',
            'number' => 'Number',
            'fbid' => 'Fbid',
            'status' => 'Status',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }
    public function getBanks()
    {
        return $this->hasMany(Banks::className(), ['id' => 'bank_id']);
    }
}
