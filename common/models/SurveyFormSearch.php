<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SurveyForm;

/**
* SurveyFormSearch represents the model behind the search form about `common\models\SurveyForm`.
*/
class SurveyFormSearch extends SurveyForm
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'created_at', 'updated_at', 'survey_id'], 'integer'],
            [['options', 'email', 'phone'], 'safe'],
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
$query = SurveyForm::find()->orderBy(['created_at' => SORT_DESC]);

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
            'survey_id' => $this->survey_id,
        ]);

        $query->andFilterWhere(['like', 'options', $this->options])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

return $dataProvider;
}
}