<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace open20\amos\events\models\search;

use open20\amos\events\models\EventRoom;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class EventRoomSearch
 * @package open20\amos\events\models\search
 */
class EventRoomSearch extends EventRoom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_name', 'available_seats'], 'safe']
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
     * This is the base search.
     * @param array $params
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function baseSearch($params)
    {
        /** @var EventRoom $eventRoomModel */
        $eventRoomModel = $this->eventsModule->createModel('EventRoom');
        $query = $eventRoomModel::find();
        $this->initOrderVars(); // Init the default search values
        $this->setOrderVars($params); // Check params to get orders value
        return $query;
    }

    /**
     * Search sort.
     * @param ActiveDataProvider $dataProvider
     */
    protected function setSearchSort($dataProvider)
    {
        // Check if can use the custom module order
        if ($this->canUseModuleOrder()) {
            $dataProvider->setSort([
                'attributes' => [
                    'room_name' => [
                        'asc' => [self::tableName() . '.room_name' => SORT_ASC],
                        'desc' => [self::tableName() . '.room_name' => SORT_DESC]
                    ],
                    'available_seats' => [
                        'asc' => [self::tableName() . '.available_seats' => SORT_ASC],
                        'desc' => [self::tableName() . '.available_seats' => SORT_DESC]
                    ],
                ]
            ]);
        }
    }

    /**
     * Base filter.
     * @param ActiveQuery $query
     * @return mixed
     */
    public function baseFilter($query)
    {
        $query->andFilterWhere(['available_seats' => $this->available_seats]);
        $query->andFilterWhere(['like', self::tableName() . '.room_name', $this->room_name]);
        return $query;
    }

    /**
     * Generic search for this model. It return all records.
     * @param array $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = $this->baseSearch($params);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->setSearchSort($dataProvider);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $this->baseFilter($query);
        return $dataProvider;
    }
}
