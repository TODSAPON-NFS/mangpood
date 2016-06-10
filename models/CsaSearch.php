<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Csa;

/**
 * CsaSearch represents the model behind the search form about `app\models\Csa`.
 */
class CsaSearch extends Csa {

    public $q;

    public function rules() {
        return [
            [['csa_id', 'csa_province_id', 'csa_district_id', 'csa_subdistrict_id', 'created_at', 'updated_at'], 'integer'],
            [['csa_type', 'csa_name_surname', 'csa_company', 'csa_email', 'csa_phone', 'csa_socialmedia', 'csa_address', 'q'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = Csa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'csa_id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions <== ปิดส่วนการใช้งานด้านล่างนี้

        /*
          $query->andFilterWhere([
          'csa_id' => $this->csa_id,
          'csa_province_id' => $this->csa_province_id,
          'csa_zipcode_id' => $this->csa_zipcode_id,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          ]);
         * 
         */

        $query->orFilterWhere(['like', 'csa_type', $this->q])
                ->orFilterWhere(['like', 'csa_name_surname', $this->q])
                ->orFilterWhere(['like', 'csa_company', $this->q])
                ->orFilterWhere(['like', 'csa_email', $this->q])
                ->orFilterWhere(['like', 'csa_phone', $this->q])
                ->orFilterWhere(['like', 'csa_socialmedia', $this->q])
                ->orFilterWhere(['like', 'csa_address', $this->q]);

        return $dataProvider;
    }

}
