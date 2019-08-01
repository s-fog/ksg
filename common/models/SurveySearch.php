<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Survey;

/**
* SurveySearch represents the model behind the search form about `common\models\Survey`.
*/
class SurveySearch extends Survey
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'created_at', 'updated_at', 'sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'seo_description', 'under_header', 'youtube', 'youtube_text', 'button_text', 'button2_text', 'cupon_header', 'cupon_text', 'cupon_image', 'cupon_button', 'preview_image', 'introtext', 'success_header', 'success_image', 'success_button', 'success_text', 'success_link_text', 'success_link', 'step_header'], 'safe'],
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
$query = Survey::find()->orderBy(['sort_order' => SORT_DESC]);

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
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'seo_h1', $this->seo_h1])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'under_header', $this->under_header])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'youtube_text', $this->youtube_text])
            ->andFilterWhere(['like', 'button_text', $this->button_text])
            ->andFilterWhere(['like', 'button2_text', $this->button2_text])
            ->andFilterWhere(['like', 'cupon_header', $this->cupon_header])
            ->andFilterWhere(['like', 'cupon_text', $this->cupon_text])
            ->andFilterWhere(['like', 'cupon_image', $this->cupon_image])
            ->andFilterWhere(['like', 'cupon_button', $this->cupon_button])
            ->andFilterWhere(['like', 'preview_image', $this->preview_image])
            ->andFilterWhere(['like', 'introtext', $this->introtext])
            ->andFilterWhere(['like', 'success_header', $this->success_header])
            ->andFilterWhere(['like', 'success_image', $this->success_image])
            ->andFilterWhere(['like', 'success_button', $this->success_button])
            ->andFilterWhere(['like', 'success_text', $this->success_text])
            ->andFilterWhere(['like', 'success_link_text', $this->success_link_text])
            ->andFilterWhere(['like', 'success_link', $this->success_link])
            ->andFilterWhere(['like', 'step_header', $this->step_header]);

return $dataProvider;
}
}