<?php

namespace app\models\search;


use app\models\Statistics;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * FaqSearch represents the model behind the search form of `backend\models\Faq`.
 */
class StatisticsSearch extends Statistics
{
    public $dataStart;
    public $dataEnd;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dataStart', 'dataEnd'], 'string'],

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

        $query = $this->findModelQuery();
        $dataProvider = $dataProvider = $this->getProvider($query);;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->dataStart) && !empty($this->dataEnd)) {
            $query->andFilterWhere([
                'between',
                'created_at',
                strtotime($this->dataStart),
                strtotime($this->dataEnd)
            ]);
        }
        if (!empty($this->dataStart) && empty($this->dataEnd)) {
            $query->andFilterWhere([
                '>',
                'created_at',
                strtotime($this->dataStart),
            ]);
        }
        if (empty($this->dataStart) && !empty($this->dataEnd)) {
            $query->andFilterWhere([
                '<',
                'created_at',
                strtotime($this->dataEnd),
            ]);
        }
        return $dataProvider;
    }

    /**
     * @param $params
     * @param $get
     * @return ActiveDataProvider
     */
    public function searchApi($params,$get)
    {

        $query = $this->findModelQuery();
        $dataProvider = $this->getProvider($query);
        $this->load($params);
        $this->dataStart = $get['dataStart'];
        $this->dataEnd = $get['dataEnd'];
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->dataStart) && !empty($this->dataEnd)) {
            $query->andFilterWhere([
                'between',
                'created_at',
                strtotime($this->dataStart),
                strtotime($this->dataEnd)
            ]);
        }
        if (!empty($this->dataStart) && empty($this->dataEnd)) {
            $query->andFilterWhere([
                '>',
                'created_at',
                strtotime($this->dataStart),
            ]);
        }
        if (empty($this->dataStart) && !empty($this->dataEnd)) {
            $query->andFilterWhere([
                '<',
                'created_at',
                strtotime($this->dataEnd),
            ]);
        }
        return $dataProvider;
    }

    /**
     * @param $query
     * @return ActiveDataProvider
     */
    private function getProvider($query)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'countClick' => [],
                'countTrial' => [],
                'countInstall' => [],
                'cRi' => [],
                'cRt' => [],
                'campaign_id'

            ]
        ]);
        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    private function findModelQuery()
    {

        return Statistics::find()
            ->select(
                [
                    'campaign_id',
                    'countClick' => 'sum(click)',
                    'countTrial' => 'sum(trial)',
                    'countInstall' => 'sum(install)',
                    'cRi' => new Expression('100/sum(click)/sum(install)'),
                    'cRt' => new Expression('100/sum(install)/sum(trial)')
                ]
            )
            ->groupBy('campaign_id');
    }

}
