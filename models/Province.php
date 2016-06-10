<?php

namespace app\models;

use yii\db\ActiveRecord;

class Province extends ActiveRecord
{

    public static function tableName()
    {
        return 'province';
    }

    public function rules()
    {
        return [
            [['province_id'], 'integer'],
            [['province_name'], 'string', 'max' => 15],
        ];
    }

    public function attributeLabels()
    {
        return [
            'province_id' => 'รหัสจังหวัด',
            'province_name' => 'ชื่อจังหวัด',
        ];
    }

    public function getZipcodes()
    {
        return $this->hasMany(Zipcode::className(), ['province_id' => 'province_id']);
    }
}