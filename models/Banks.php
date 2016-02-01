<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $status
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 50]
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
            'code' => 'Code',
            'name' => 'Name',
            'status' => 'Status',
        ];
    }

    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['bank_id' => 'id']);
    }
}
