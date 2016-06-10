<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "subdistrict".
 *
 * @property integer $subdistrict_id
 * @property integer $district_id
 * @property string $subdistrict_name
 * @property integer $subdistrict_zipcode
 */
class Subdistrict extends ActiveRecord
{

    public static function tableName()
    {
        return 'subdistrict';
    }

    public function rules()
    {
        return [
            [['subdistrict_id', 'district_id', 'subdistrict_name', 'subdistrict_zipcode'], 'required'],
            [['subdistrict_id', 'district_id', 'subdistrict_zipcode'], 'integer'],
            [['subdistrict_name'], 'string', 'max' => 23],
        ];
    }

    public function attributeLabels()
    {
        return [
            'subdistrict_id' => 'รหัสตำบล / แขวง',
            'district_id' => 'รหัสอำเภอ / เขต',
            'subdistrict_name' => 'แขวง / ตำบล',
            'subdistrict_zipcode' => 'รหัสไปรษณีย์',
        ];
    }
}
