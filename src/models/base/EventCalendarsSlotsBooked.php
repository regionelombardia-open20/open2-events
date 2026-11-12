<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-events
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

use open20\amos\core\user\User;
use Yii;

/**
 * This is the base-model class for table "event_calendars_slots_booked".
 *
 * @property integer $id
 * @property integer $event_calendars_slots_id
 * @property integer $user_id
 * @property string $booked_at
 * @property string $affiliation
 * @property string $cellphone
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \open20\amos\events\models\EventCalendars $eventCalendarsSlots
 * @property \open20\amos\events\models\User $user
 */
class  EventCalendarsSlotsBooked extends \open20\amos\core\record\Record
{
    public $isSearch = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_calendars_slots_booked';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_calendars_slots_id'], 'required'],
            [['event_calendars_slots_id', 'user_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['affiliation', 'cellphone', 'booked_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['event_calendars_slots_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventCalendars::className(), 'targetAttribute' => ['event_calendars_slots_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('amosevents', 'ID'),
            'event_calendars_slots_id' => Yii::t('amosevents', 'Event'),
            'user_id' => Yii::t('amosevents', 'User'),
            'booked_at' => Yii::t('amosevents', 'Booked at'),
            'created_at' => Yii::t('amosevents', 'Created at'),
            'updated_at' => Yii::t('amosevents', 'Updated at'),
            'deleted_at' => Yii::t('amosevents', 'Deleted at'),
            'created_by' => Yii::t('amosevents', 'Created by'),
            'updated_by' => Yii::t('amosevents', 'Updated by'),
            'deleted_by' => Yii::t('amosevents', 'Deleted by'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventCalendarsSlots()
    {
        return $this->hasOne(\open20\amos\events\models\EventCalendarsSlots::className(), ['id' => 'event_calendars_slots_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
