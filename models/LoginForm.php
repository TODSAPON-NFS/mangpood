<?php

namespace app\models;

use Yii;
use yii\base\Model;

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
    public $dateRememberMe = 30;

    public function rules() {
        return [
            // username and password are both required
            [['user_name', 'user_password'], 'required', 'message' => '{attribute}ห้ามเป็นค่าว่าง'],
            [['user_name'], 'string', 'max' => 20],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['dateRememberMe'], 'integer', 'min'=>1,'max'=>365],
            // password is validated by validatePassword()
            ['user_password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'user_name' => 'ชื่อผู้ใช้',
            'user_password' => 'รหัสผ่าน',
            'rememberMe' => 'จำผู้ใช้งานนี้ไว้',
            'dateRememberMe' => 'จำนวนวัน',
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            //ถ้าผู้ใช้งานเป็นค่าว่าง จึงทำให้เรียกใช้ Object ของ User ไม่ได้ พอเรียกไม่ได้ ก็เอาค่าไป validatePassword ไม่ได้ 
            if ($user == null) {
                $this->addError("user_name");
                Yii::$app->session->setFlash('invalidUsernamePassword', '&nbsp;ชื่อผู้ใช้งานไม่ถูกต้อง');
            }

            elseif ($user != null) {
                if (Yii::$app->security->validatePassword($this->user_password, $user->user_password) == false) {
                    $this->addError("user_password");
                    Yii::$app->session->setFlash('invalidUsernamePassword', '&nbsp;รหัสผ่านไม่ถูกต้อง');
                }
                else
                {}
            }

        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * $this->dateRememberMe : 0);
        }
        return false;
    }

    public function getUser() {
        
        return User::findOne(['user_name' => $this->user_name, 'user_status' => User::STATUS_ACTIVE]); 
                
    }

}
