<?php
namespace app\models;

use Yii;
use app\models\parents\SystemUserParent;
use yii\web\IdentityInterface;

class SystemUser extends SystemUserParent implements IdentityInterface
{
    public $set_update_time = false;

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        
        ]);
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
        
        ]);
    }

    public static function getOptions($model = false)
    {
        $res = parent::getOptions($model);

        return $res;
    }

    public function getTitle() {
        return $this->getFull_name();
    }

    public function setFull_name($value) {
        $parts = preg_split('/\s+/', $value);

        if (count($parts) == 1) {
            $this->surname = '';
            $this->name = $parts[0];
            $this->second_name = '';
        }
        if (count($parts) == 2) {
            $this->surname = $parts[0];
            $this->name = $parts[1];
            $this->second_name = '';
        }
        if (count($parts) >= 3) {
            $this->surname = $parts[0];
            $this->name = $parts[1];
            $this->second_name = $parts[2];
        }
    }

    public function getFull_name() {
        $res = [];
        if ($this->surname) $res[] = $this->surname;
        if ($this->name) $res[] = $this->name;
        if ($this->second_name) $res[] = $this->second_name;

        return implode(' ', $res);
    }

    public function getFull_login() {
        $res = [];
        if ($this->login_username) $res[] = $this->login_username;
        if ($this->login_email) $res[] = $this->login_email;
        if ($this->login_phone) $res[] = $this->login_phone_input;

        return implode(', ', $res);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function setPassword_input($value)
    {
        parent::setPassword_input($value);

        $this->access_token = substr(md5(time() / 2), 10, 16) . substr(md5(time() / 3), 5, 16);
    }

    public function getToken() {
        if (empty($this->access_token)) {
            $this->access_token = substr(md5(time() / 2), 10, 16) . substr(md5(time() / 3), 5, 16);
            $this->save(false, ['access_token']);
        }

        return $this->access_token;
    }
}