<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior; //เพื่อเรียกใช้คลาส TimestampBehavior
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property integer $product_code
 * @property integer $category_id
 * @property string $product_name
 * @property string $product_detail
 * @property string $product_price
 * @property string $product_wholesale_price
 * @property integer $product_amount
 * @property string $product_cost_per_unit
 * @property string $product_cost_per_unit_updated
 * @property string $product_discount
 * @property string $product_weight
 * @property integer $product_stock_alert
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $product_status
 *
 * @property Category $category
 */

class Product extends ActiveRecord {

    const CONTROLLER_ACTION_VIEW = 'product/view';
    const CONTROLLER_ACTION_DELETEONE = 'product/delete';
    const CONTROLLER_ACTION_DELETEALL = 'product/deleteall';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName() {
        return 'product';
    }

    public function rules() {
        return [
            [['category_id', 'product_name', 'product_cost_per_unit', 'product_price', 'product_status'], 'required'],
            [['product_name'], 'trim'],
            [['product_detail', 'product_status'], 'string'],
            ['product_code', 'unique', 'message' => 'มีรหัสสินค้านี้ในระบบแล้ว'],
            ['product_code', 'string', 'max' => 20],
            [['product_amount', 'product_weight', 'product_stock_alert'], 'integer'], //จำนวนเต็ม
            [['product_price', 'product_cost_per_unit', 'product_discount', 'product_wholesale_price'], 'number'], //จำนวนจริง (ทศนิยม)
            [['product_amount', 'product_stock_alert'], 'integer', 'min' => 0, 'max' => 999999],
            [['product_cost_per_unit_updated'], 'safe'],
            [['created_at', 'updated_at'], 'safe'], //ระบบอัตโนมัติ
            ['product_status', 'default', 'value' => self::STATUS_ACTIVE],
            [['product_amount', 'product_discount', 'product_wholesale_price', 'product_weight', 'product_stock_alert'], 'default', 'value' => 0],
            ['product_status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]], //in range คือ ต้องมีค่าตามที่ระบุ
            [['product_name'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'product_id' => 'PID',
            'product_code' => 'รหัสสินค้า',
            'category_id' => 'กลุ่มสินค้า',
            'product_name' => 'ชื่อสินค้า',
            'product_detail' => 'รายละเอียด',
            'product_price' => 'ราคาขายปลีก',
            'product_wholesale_price' => 'ราคาขายส่ง',
            'product_amount' => 'จำนวนคงเหลือในคลัง',
            'product_cost_per_unit' => 'ราคาต้นทุน',
            'product_cost_per_unit_updated' => 'Product Cost Per Unit Updated',
            'product_discount' => 'ราคาพิเศษ', //เช่น ราคาขาย (ราคาปกติ) 100 บาท ราคาพิเศษ 70 บาท
            'product_weight' => 'น้ำหนัก (กรัม)',
            'product_stock_alert' => 'จุดสั่งซื้อ',
            'created_at' => 'สร้างขึ้นเมื่อ',
            'updated_at' => 'ปรับปรุงเมื่อ',
            'product_status' => 'สถานะ',
        ];
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }

    public static function categoryDropdownList() {

        $modelCategory['categoryList'] = ArrayHelper::map(Category::find()->all(), 'category_id', 'category_name');
        $modelCategory['count'] = Category::find()->count();

        return $modelCategory;
    }

}
