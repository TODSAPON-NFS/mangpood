<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

class District extends ActiveRecord
{

    public static function tableName()
    {
        return 'district';
    }

    public function rules()
    {
        return [
            [['district_id', 'province_id', 'district_name'], 'required'],
            [['district_id', 'province_id'], 'integer'],
            [['district_name'], 'string', 'max' => 25],
        ];
    }

    public function attributeLabels()
    {
        return [
            'district_id' => 'รหัสอำเภอ / เขต',
            'province_id' => 'รหัสจังหวัด',
            'district_name' => 'ชื่ออำเภอ / เขต',
        ];
    }
}
