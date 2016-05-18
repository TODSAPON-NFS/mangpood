<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_password
 * @property string $user_email
 * @property integer $user_status
 * @property string $user_created_at
 * @property string $user_updated_at
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName() {
        return 'user';
    }

    public function rules() {
        return [
            ['user_status', 'default', 'value' => self::STATUS_ACTIVE],
            ['user_status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['user_name', 'user_password', 'user_email'], 'required'],
            [['user_status'], 'integer'],
            [['user_created_at', 'user_updated_at'], 'safe'],
            [['user_name'], 'string', 'max' => 20],
            [['user_password'], 'string', 'max' => 60],
            [['user_email'], 'string', 'max' => 50],
            [['user_name'], 'unique'],
            [['user_email'], 'unique'],
        ];
    }

    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'user_name' => 'ชื่อผู้ใช้',
            'user_password' => 'รหัสผ่าน',
            'user_email' => 'อีเมล์',
            'user_status' => 'สถานะ',
            'user_created_at' => 'วันที่สร้าง',
            'user_updated_at' => 'วันที่ปรับปรุง',
        ];
    }

    public function getAuthKey() {}

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey) {}

    public static function findIdentity($id) {
        return static::findOne(['user_id' => $id, 'user_status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {}
}