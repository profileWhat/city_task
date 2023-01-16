<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class CitySearch extends City
{
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 128],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = City::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}