<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
* ProductSearch represents the model behind the search form about `common\models\Product`.
*/
class ProductSearch extends Product
{
        public $supplierName;
        public $ppArtikul;

        public function rules()
        {
                return [
                    [['id', 'hit', 'parent_id', 'brand_id', 'supplier', 'price', 'price_old', 'currency_id', 'adviser_id', 'created_at', 'updated_at'], 'integer'],
                    [['name', 'alias', 'code', 'description', 'adviser_text', 'instruction', 'video', 'disallow_xml', 'seo_h1', 'seo_title', 'seo_keywords', 'seo_description', 'supplierName', 'ppArtikul'], 'safe'],
                ];
        }

        public function scenarios()
        {
                return Model::scenarios();
        }

        public function search($params)
        {
                $query = Product::find()
                    ->joinWith(['supplierModel', 'productParams'])
                    ->orderBy(['sort_order' => SORT_DESC]);

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);

                $this->load($params);

                if (!$this->validate()) {
                        return $dataProvider;
                }

                $query->andFilterWhere([
                    'id' => $this->id,
                    'hit' => $this->hit,
                    'parent_id' => $this->parent_id,
                    'brand_id' => $this->brand_id,
                    'supplier' => $this->supplier,
                    'price' => $this->price,
                    'price_old' => $this->price_old,
                    'currency_id' => $this->currency_id,
                    'adviser_id' => $this->adviser_id,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                ]);

                $query->andFilterWhere(['like', Product::tableName().'.name', $this->name])
                    ->andFilterWhere(['like', 'alias', $this->alias])
                    ->andFilterWhere(['like', 'code', $this->code])
                    ->andFilterWhere(['like', 'description', $this->description])
                    ->andFilterWhere(['like', 'adviser_text', $this->adviser_text])
                    ->andFilterWhere(['like', 'instruction', $this->instruction])
                    ->andFilterWhere(['like', 'video', $this->video])
                    ->andFilterWhere(['like', 'disallow_xml', $this->disallow_xml])
                    ->andFilterWhere(['like', 'seo_h1', $this->seo_h1])
                    ->andFilterWhere(['like', 'seo_title', $this->seo_title])
                    ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
                    ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

                if (!empty($this->supplierName)) {
                        $query->andFilterWhere([Supplier::tableName().'.id' => $this->supplierName]);
                }

                if (!empty($this->ppArtikul)) {
                        $query->andFilterWhere(['like', ProductParam::tableName().'.artikul', $this->ppArtikul]);
                }

                return $dataProvider;
        }
}