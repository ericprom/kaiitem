<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user_master".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $name
 * @property string $fbid
 * @property string $auth_key
 * @property string $email
 * @property string $phone
 * @property string $location
 * @property string $bio
 * @property double $created_on
 * @property double $updated_on
 */
class UserMaster extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['username', 'name', 'fbid', 'auth_key', 'email', 'phone', 'location', 'bio', 'created_on', 'updated_on'], 'required'],
            [['bio'], 'string'],
            [['created_on', 'updated_on'], 'number'],
            [['username', 'name', 'email', 'phone', 'location'], 'string', 'max' => 50],
            [['fbid'], 'string', 'max' => 30],
            [['auth_key'], 'string', 'max' => 32]
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
            'user_id' => 'User ID',
            'username' => 'Username',
            'name' => 'Name',
            'fbid' => 'Fbid',
            'auth_key' => 'Auth Key',
            'email' => 'Email',
            'phone' => 'Phone',
            'location' => 'Location',
            'bio' => 'Bio',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id ]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
        return $this->auth_key;
    }
}
