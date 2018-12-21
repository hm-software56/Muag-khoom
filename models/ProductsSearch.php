<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'qautity', 'category_id', 'user_id'], 'integer'],
            [['name', 'date', 'pricesale', 'image'], 'safe'],
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
        $query = Products::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'qautity' => $this->qautity,
            'date' => $this->date,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'status'=>'1',
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'pricesale', $this->pricesale]);
            if(empty($_GET['sort'])){
                $query->orderBy('id DESC');
            }
        if(!empty($this->image))
        {
            $categary=Category::find()->select('id')->where(['like','name',$this->image])->asArray()->all();
            $id=[];
            foreach($categary as $categary)
            {
                $id[]=$categary['id'];
            }
            $query->andFilterWhere(['in', 'category_id', $id]);
        }    
        return $dataProvider;
    }
}
