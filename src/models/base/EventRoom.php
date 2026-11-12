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

use open20\amos\core\record\Record;
use open20\amos\events\AmosEvents;

/**
 * Class EventRoom
 *
 * This is the base-model class for table "event_room".
 *
 * @property integer $id
 * @property string $room_name
 * @property integer $available_seats
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \open20\amos\events\models\Event[] $events
 *
 * @package open20\amos\events\models\base
 */
abstract class EventRoom extends Record
{
    /**
     * @var AmosEvents $eventsModule
     */
    public $eventsModule = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->eventsModule = AmosEvents::instance();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_name', 'available_seats'], 'required'],
            [['room_name'], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['available_seats'], 'integer', 'min' => 1],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => AmosEvents::t('amosevents', 'ID'),
            'room_name' => AmosEvents::t('amosevents', '#room_name'),
            'available_seats' => AmosEvents::t('amosevents', '#available_seats'),
            'created_at' => AmosEvents::t('amosevents', 'Created At'),
            'updated_at' => AmosEvents::t('amosevents', 'Updated At'),
            'deleted_at' => AmosEvents::t('amosevents', 'Deleted At'),
            'created_by' => AmosEvents::t('amosevents', 'Created By'),
            'updated_by' => AmosEvents::t('amosevents', 'Updated By'),
            'deleted_by' => AmosEvents::t('amosevents', 'Deleted By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany($this->eventsModule->model('Event'), ['event_room_id' => 'id']);
    }
}
