<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Statistics]].
 *
 * @see \app\models\Statistics
 */
class StatisticsQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $event
     * @return StatisticsQuery
     */
    public function whereEvent($event)
    {
        return $this->andWhere(['event' => $event]);
    }
}
