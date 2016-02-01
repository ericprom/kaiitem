<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "tmtopup".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $ref_1
 * @property string $ref_2
 * @property string $ref_3
 * @property string $passkey
 * @property string $fbid
 * @property double $created_on
 * @property double $updated_on
 */
class Tmtopup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmtopup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['uid', 'ref_1', 'ref_2', 'ref_3', 'passkey', 'fbid', 'created_on', 'updated_on'], 'required'],
            [['uid'], 'integer'],
            [['created_on', 'updated_on'], 'number'],
            [['ref_1', 'ref_2', 'ref_3', 'passkey'], 'string', 'max' => 50],
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
            'uid' => 'Uid',
            'ref_1' => 'Ref 1',
            'ref_2' => 'Ref 2',
            'ref_3' => 'Ref 3',
            'passkey' => 'Passkey',
            'fbid' => 'Fbid',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }
}
