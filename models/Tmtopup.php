<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tmtopup".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $ref1
 * @property string $ref2
 * @property string $ref3
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
            // [['uid', 'ref1', 'ref2', 'ref3', 'fbid', 'created_on', 'updated_on'], 'required'],
            [['uid'], 'integer'],
            [['created_on', 'updated_on'], 'number'],
            [['ref1', 'ref2', 'ref3'], 'string', 'max' => 50],
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
            'ref1' => 'Ref1',
            'ref2' => 'Ref2',
            'ref3' => 'Ref3',
            'fbid' => 'Fbid',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }
}
