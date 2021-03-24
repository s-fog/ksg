<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Delivery;

/**
* DeliverySearch represents the model behind the search form about `common\models\Delivery`.
*/
class DeliverySearch extends Delivery
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'gte', 'lt', 'moscow_price', 'other_price'], 'integer'],
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
$query = Delivery::find();

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
            'gte' => $this->gte,
            'lt' => $this->lt,
            'moscow_price' => $this->moscow_price,
            'other_price' => $this->other_price,
        ]);

return $dataProvider;
}
}