<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior; //เพื่อเรียกใช้คลาส TimestampBehavior
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "customer_supplier_alliance".
 *
 * @property string $csa_id
 * @property string $csa_type
 * @property string $csa_name_surname
 * @property string $csa_company
 * @property string $csa_email
 * @property string $csa_phone
 * @property string $csa_socialmedia
 * @property integer $csa_province_id
 * @property integer $csa_district_id
 * @property integer $csa_subdistrict_id
 * @property integer $csa_zipcode
 * @property string $csa_address
 * @property string $csa_note
 * @property integer $created_at
 * @property integer $updated_at
 */
class Csa extends ActiveRecord {

    const CONTROLLER_ACTION_VIEW = 'csa/view';
    const CONTROLLER_ACTION_DELETEONE = 'csa/delete';
    const CONTROLLER_ACTION_DELETEALL = 'csa/deleteall';

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName() {
        return 'customer_supplier_alliance';
    }

    public function rules() {
        return [
            ['csa_name_surname', 'required'],
            ['csa_name_surname', 'unique'],
            ['csa_name_surname', 'validateCsaNameSurname'], //สร้าง Public Function สำหรับ Validation
            [['csa_type', 'csa_address'], 'string'],
            [['csa_name_surname'], 'string', 'max' => 100],
            [['csa_zipcode'], 'string', 'max' => 10],
            [['csa_company'], 'string', 'max' => 75],
            [['csa_phone'], 'string', 'max' => 20],
            [['csa_socialmedia'], 'string', 'max' => 100],
            ['csa_type', 'required', 'message' => 'โปรดเลือกประเภทของลูกค้า คู่ค้า และพันธมิตรธุรกิจ'],
            ['csa_type', 'in', 'range' => ['Customer', 'Supplier', 'Both', 'Alliance']], //in range คือ ต้องมีค่าตามที่ระบุ
            ['csa_email', 'email'],
            ['csa_email', 'unique'],
            ['csa_zipcode', 'default', 'value' => '00000'],
            [['csa_name_surname', 'csa_email', 'csa_company', 'csa_socialmedia', 'csa_note'], 'trim'],
            ['csa_name_surname', 'default', 'value' => 'ลูกค้าทั่วไป'],
            [['csa_province_id', 'csa_district_id', 'csa_subdistrict_id', 'created_at', 'updated_at'], 'integer'],
            [['csa_province_id', 'csa_district_id', 'csa_subdistrict_id'], 'default', 'value' => 0],
            [['created_at', 'updated_at'], 'safe'], //ระบบอัตโนมัติ
        ];
    }

    public function attributeLabels() {
        return [
            'csa_id' => 'รหัสลูกค้า',
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
            'created_at' => 'สร้างขึ้นเมื่อ',
            'updated_at' => 'ปรับปรุงเมื่อ',
        ];
    }
    
    //ตรวจสอบว่ามีเฉพาะคำว่า "คุณ" เฉยๆ หรือไม่?
    public function validateCsaNameSurname(){
        
        if($this->csa_name_surname == trim("คุณ")){
            $this->addError('csa_name_surname', 'กรุณาเติม ชื่อ - นามสกุล หลังคำว่า "คุณ" ด้วย');
        }
        
        //ถ้า csa_name_surname ไม่มีคำว่า "คุณ" หรือ คำว่า "คุณ" ไม่อยู่ในตำแหน่งแรก
        if(strpos($this->csa_name_surname, "คุณ") == null || strpos($this->csa_name_surname, "คุณ") != 0){
            $csa_name_surname = 'คุณ'.trim($this->csa_name_surname).'';
            
            $count = Csa::find()->where(['csa_name_surname' => $csa_name_surname])->count();
            
            if($count > 0){
                $this->addError('csa_name_surname', 'ชื่อ - นามสกุล "'.$csa_name_surname.'" ถูกใช้ไปแล้ว');
            }
        }

    }
    
    public static function provinceDropdownList() {

        $modelProvince = ArrayHelper::map(Province::find()->all(), 'province_id', 'province_name');

        return $modelProvince;
    }

    public static function districtDropdownList($province_id) {

        $modelDistrict = ArrayHelper::map(District::find()->where(["province_id" => $province_id])->orderBy(["district_name" => SORT_ASC])->all(), 'district_id', 'district_name');

        return $modelDistrict;
    }

    public static function subdistrictDropdownList($district_id) {

        $modelSubDistrict = ArrayHelper::map(Subdistrict::find()->where(["district_id" => $district_id])->orderBy(["subdistrict_name" => SORT_ASC])->all(), 'subdistrict_id', 'subdistrict_name');

        return $modelSubDistrict;
    }

    /* === Name Request === */

    public static function subdistrictNameRequest($subdistrict_id) {

        if (!empty($subdistrict_id)) {
            $modelSubDistrict = Subdistrict::findOne([
                        'subdistrict_id' => $subdistrict_id,
            ]);

                return $modelSubDistrict->subdistrict_name;

        } else {
            return false;
        }
    }

    public static function districtNameRequest($district_id) {

        if (!empty($district_id)) {
            $modelDistrict = District::findOne([
                        'district_id' => $district_id,
            ]);

            return ' ' . $modelDistrict->district_name;
        } else {
            return false;
        }
    }

    public static function provinceNameRequest($province_id) {

        if (!empty($province_id)) {
            $modelProvince = Province::findOne([
                        'province_id' => $province_id,
            ]);

            return $modelProvince->province_name;
        } else {
            return false;
        }
    }

    public static function zipcodeRequest($zipcode) {

        if (!empty($zipcode)) {
            return ' ' . $zipcode;
        } else {
            return false;
        }
    }

}
