<?php

namespace common\models;

use backend\models\ChangerForm;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Changer;

/**
 * ChangerSearch represents the model behind the search form about `common\models\Changer`.
 */
class ChangerSearch extends Changer
{
        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                    [['id', 'created_at', 'updated_at', 'product_id', 'supplier_id', 'brand_id'], 'integer'],
                    [['old_price', 'new_price', 'percent'], 'number'],
                ];
        }

        /**
         * @inheritdoc
         */
        public function scenarios()
        {
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
        public function search($params)
        {
                $query = Changer::find()->joinWith(['product', 'brand', 'supplier'])->orderBy(['created_at' => SORT_DESC]);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);

                $this->load($params);

                if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
                        return $dataProvider;
                }

                $query->andFilterWhere([
                    'id' => $this->id,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                    'product_id' => $this->product_id,
                    'old_price' => $this->old_price,
                    'new_price' => $this->new_price,
                    'percent' => $this->percent,
                    'supplier_id' => $this->supplier_id,
                    Changer::tableName().'.brand_id' => $this->brand_id,
                ]);

                return $dataProvider;
        }
}