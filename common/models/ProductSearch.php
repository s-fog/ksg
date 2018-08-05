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
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'hit', 'parent_id', 'brand_id', 'supplier', 'price', 'price_old', 'currency_id', 'adviser_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'alias', 'code', 'artikul', 'description', 'adviser_text', 'instruction', 'video', 'disallow_xml', 'seo_h1', 'seo_title', 'seo_keywords', 'seo_description'], 'safe'],
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
$query = Product::find()->orderBy(['sort_order' => SORT_DESC]);

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'artikul', $this->artikul])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'adviser_text', $this->adviser_text])
            ->andFilterWhere(['like', 'instruction', $this->instruction])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'disallow_xml', $this->disallow_xml])
            ->andFilterWhere(['like', 'seo_h1', $this->seo_h1])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

return $dataProvider;
}
}