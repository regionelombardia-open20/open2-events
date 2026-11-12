<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\models\base
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

namespace open20\amos\events\models\base;

use open20\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class EventTypeContext
 * This is the base-model class for table "event_type_context".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * @property \open20\amos\events\models\EventType[] $eventTypes
 *
 * @package open20\amos\events\models\base
 */
class EventTypeContext extends \open20\amos\core\record\Record
{
    const EVENT_TYPE_CONTEXT_GENERIC = 1;
    const EVENT_TYPE_CONTEXT_PROJECT = 2;
    const EVENT_TYPE_CONTEXT_MATCHMAKING = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_type_context';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosEvents::t('amosevents', 'ID'),
            'title' => AmosEvents::t('amosevents', 'Title'),
            'description' => AmosEvents::t('amosevents', 'Description')
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventTypes()
    {
        return $this->hasMany(AmosEvents::instance()->model('EventType'), ['id' => 'event_context_id']);
    }
}
