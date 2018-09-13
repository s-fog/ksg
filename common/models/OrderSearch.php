<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
* OrderSearch represents the model behind the search form about `common\models\Order`.
*/
class OrderSearch extends Order
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'created_at', 'updated_at', 'paid', 'status'], 'integer'],
            [['payment', 'name', 'phone', 'email', 'address', 'comment', 'products'], 'safe'],
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
$query = Order::find()->orderBy(['created_at' => SORT_DESC]);

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
            'status' => $this->status,
            'paid' => $this->paid,
        ]);

        $query->andFilterWhere(['like', 'payment', $this->payment])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comm', $this->comm])
            ->andFilterWhere(['like', 'products', $this->products]);

        if (!empty($this->check)) {
                if ($this->check == 'empty') {
                        $query->andWhere("`check` IS NULL OR `check` = ''");
                } else {
                        $query->andWhere("`check` != ''");
                }
        }

return $dataProvider;
}
}