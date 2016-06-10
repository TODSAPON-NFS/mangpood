<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $q;
    
    public function rules()
    {
        return [
            [['product_id', 'category_id', 'product_amount', 'product_weight', 'product_stock_alert', 'created_at', 'updated_at'], 'integer'],
            [['product_name', 'product_detail', 'product_cost_per_unit_updated', 'product_status', 'q'], 'safe'],
            [['product_price', 'product_cost_per_unit', 'product_discount'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'product_id' => SORT_DESC,
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
            'product_id' => $this->product_id,
            'category_id' => $this->category_id,
            'product_price' => $this->product_price,
            'product_amount' => $this->product_amount,
            'product_cost_per_unit' => $this->product_cost_per_unit,
            'product_cost_per_unit_updated' => $this->product_cost_per_unit_updated,
            'product_discount' => $this->product_discount,
            'product_weight' => $this->product_weight,
            'product_stock_alert' => $this->product_stock_alert,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
         * 
         */

        $query->orFilterWhere(['like', 'product_name', $this->q])
            ->orFilterWhere(['like', 'product_detail', $this->q])
            ->orFilterWhere(['like', 'product_price', $this->q]);

        return $dataProvider;
    }
}
