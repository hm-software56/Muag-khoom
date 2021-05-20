<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductTransfer;

/**
 * ProductTransferSearch represents the model behind the search form of `app\models\ProductTransfer`.
 */
class ProductTransferSearch extends ProductTransfer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'branch_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ProductTransfer::find();

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
            'date_create' => $this->date_create,
            'date_edit' => $this->date_edit,
            'status' => $this->status,
        ]);
        if (!empty(\Yii::$app->session['user']->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->session['user']->branch_id]);
        } else {
            $query->andFilterWhere(['branch_id' => $this->branch_id]);
        }
        $query->orderBy('id', 'DESC');
        return $dataProvider;
    }
}
