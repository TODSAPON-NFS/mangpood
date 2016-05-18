<?php

namespace app\models;

use Yii;
use yii\base\Model;
//use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model {

    public $user_name;
    public $user_password;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['user_name', 'user_password'], 'required', 'message' => '{attribute}ห้ามเป็นค่าว่าง'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels() {
        return [
            'user_name' => 'ชื่อผู้ใช้',
            'user_password' => 'รหัสผ่าน',
            'rememberMe' => 'จำผู้ใช้งานนี้ไว้',
        ];
    }

    public function login() {
        
        $user_password_hash = hash_hmac("sha256", $this->user_password, "mangpood");
        
        $count = User::find()
                ->where('user_name = :user_name', [':user_name' => $this->user_name])
                ->andWhere('user_password = :user_password', [':user_password' => $user_password_hash])
                ->count();

        if ($count == 1) {
            
            Yii::$app->session->setFlash('invalidUsernamePassword', 'ถูกต้อง');
            Yii::$app->user->login($this->user_name, $this->rememberMe ? 3600 * 24 * 30 : 0);
            return true;
            
        } else {
            
            Yii::$app->session->setFlash('invalidUsernamePassword', 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
            return false;
        }
    }

}
