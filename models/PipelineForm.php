<?php

namespace app\models;

use Yii;
use yii\base\Model;

class PipelineForm extends Model {

    const CONTROLLER_ACTION_VIEW = 'pipeline/view';
    const CONTROLLER_ACTION_DELETEONE = 'pipeline/delete';
    const CONTROLLER_ACTION_DELETEALL = 'pipeline/deleteall';

    public $pipeline_date;
    public $pipeline_note;
    public $csa_name_surname;
    public $csa_type;
    public $csa_company;
    public $csa_id;
    public $csa_phone;
    public $csa_email;
    public $csa_socialmedia;
    public $csa_address;
    public $csa_subdistrict_id;
    public $csa_district_id;
    public $csa_province_id;
    public $csa_zipcode;
    public $csa_note;
    public $product_code = [];
    public $product_name = [];
    public $product_amount = [];
    public $product_price = [];
    public $product_weight = [];
    public $product_price_sum;
    public $product_amount_sum;
    public $product_amount_weight;
    public $product_price_per_piece_sum;

    public function rules() {
        return [
            ['pipeline_date', 'required', 'message' => ''],
            ['csa_name_surname', 'required'],
            ['csa_name_surname', 'validateCsaNameSurname'], //สร้าง Public Function สำหรับ Validation
            [['csa_type', 'csa_address', 'pipeline_note'], 'string'],
            [['csa_name_surname'], 'string', 'max' => 100],
            [['csa_zipcode'], 'string', 'max' => 10],
            [['csa_company'], 'string', 'max' => 75],
            [['csa_phone'], 'string', 'max' => 20],
            [['csa_socialmedia'], 'string', 'max' => 100],
            ['csa_type', 'required', 'message' => 'โปรดเลือกประเภทของลูกค้า คู่ค้า และพันธมิตรธุรกิจ'],
            ['csa_type', 'in', 'range' => ['Customer', 'Supplier', 'Both', 'Alliance']], //in range คือ ต้องมีค่าตามที่ระบุ
            ['csa_email', 'email'],
            ['csa_zipcode', 'default', 'value' => '00000'],
            [['csa_name_surname', 'csa_email', 'csa_company', 'csa_socialmedia', 'csa_note'], 'trim'],
            ['csa_name_surname', 'default', 'value' => 'ลูกค้าทั่วไป'],
            [['csa_province_id', 'csa_district_id', 'csa_subdistrict_id'], 'default', 'value' => 0],
            
            [['product_code', 'product_name', 'product_amount', 'product_price', 'product_price_sum', 'product_amount_sum', 'product_amount_weight'], 'safe'],
            ['product_weight', 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'pipeline_date' => 'วันที่',
            'csa_id' => 'รหัส CSA',
            'csa_type' => 'ประเภทลูกค้า',
            'csa_name_surname' => 'ชื่อ - นามสกุล',
            'csa_company' => 'องค์กร',
            'csa_email' => 'อีเมล์',
            'csa_phone' => 'โทรศัพท์',
            'csa_socialmedia' => 'สื่อสังคมออนไลน์',
            'csa_province_id' => 'จังหวัด',
            'csa_district_id' => 'อำเภอ / เขต',
            'csa_subdistrict_id' => 'ตำบล / แขวง',
            'csa_zipcode' => 'รหัสไปรษณีย์',
            'csa_address' => 'ที่อยู่',
            'csa_note' => 'หมายเหตุ',
            'product_code' => 'รหัส',
            'product_name' => 'รายการสินค้า',
            'product_amount' => 'จำนวน',
            'product_price' => 'ราคา',
            'pipeline_note' => 'รายละเอียดเหตุการณ์นี้',
        ];
    }

    //ตรวจสอบว่ามีเฉพาะคำว่า "คุณ" เฉยๆ หรือไม่?
    public function validateCsaNameSurname() {

        if ($this->csa_name_surname == trim("คุณ")) {
            $this->addError('csa_name_surname', 'กรุณาเติม ชื่อ - นามสกุล หลังคำว่า "คุณ" ด้วย');
        }
    }

}
