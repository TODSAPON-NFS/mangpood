<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property string $category_name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends ActiveRecord {

    const CONTROLLER_ACTION_VIEW = 'category/view';
    const CONTROLLER_ACTION_DELETEONE = 'category/delete';
    const CONTROLLER_ACTION_DELETEALL = 'category/deleteall';

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName() {
        return 'category';
    }

    public function rules() {
        return [
            [['category_name'], 'required'],
            [['category_name'], 'unique'],
            [['created_at', 'updated_at'], 'safe'], //ระบบอัตโนมัติ
            [['category_name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels() {
        return [
            'category_id' => 'รหัสกลุ่มสินค้า',
            'category_name' => 'ชื่อกลุ่มสินค้า',
            'created_at' => 'สร้างขึ้นเมื่อ',
            'updated_at' => 'ปรับปรุงเมื่อ',
        ];
    }

}
