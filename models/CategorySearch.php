<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;
use app\models\DeleteAllForm;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category {

    public $q; //<== เพิ่มตรงนี้

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['category_name', 'q'], 'safe'], //<== เพิ่มตรงนี้
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {

        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'category_id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        /*
          $query->andFilterWhere([
          'category_id' => $this->category_id,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          ]);
         */

        $query->orFilterWhere(['like', 'category_name', $this->q]); //<== เพิ่มตรงนี้

        return $dataProvider;
    }

}
