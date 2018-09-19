<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category;

/**
* CategorySearch represents the model behind the search form about `common\models\Category`.
*/
class CategorySearch extends Category
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'type', 'created_at', 'updated_at', 'sort_order', 'parent_id', 'priority', 'active'], 'integer'],
            [['name', 'alias', 'text_advice', 'descr', 'image_catalog', 'image_menu', 'video', 'disallow_xml', 'seo_h1', 'seo_title', 'seo_keywords', 'seo_description'], 'safe'],
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
$query = Category::find()->orderBy(['sort_order' => SORT_DESC]);

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
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort_order' => $this->sort_order,
            'parent_id' => $this->parent_id,
            'priority' => $this->priority,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'text_advice', $this->text_advice])
            ->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'image_catalog', $this->image_catalog])
            ->andFilterWhere(['like', 'image_menu', $this->image_menu])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'disallow_xml', $this->disallow_xml])
            ->andFilterWhere(['like', 'seo_h1', $this->seo_h1])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description]);

return $dataProvider;
}
}