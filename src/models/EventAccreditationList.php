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

namespace open20\amos\events\models;

use open20\amos\core\validators\CFValidator;
use open20\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $position
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 */
class EventAccreditationList extends \open20\amos\core\record\Record
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_accreditation_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [[
                'title',
            ], 'string'],
            [[
                'id',
                'event_id',
                'position',
            ], 'integer'],
            [[
                'title',
                'id',
                'event_id',
                'position',
            ], 'safe'],
            [[
                'title',
                'position',
            ], 'required'],
        ]);
    }

    /**
     * @return Event|null
     */
    public function getEvent() {
        /** @var Event $eventModel */
        $eventModel = AmosEvents::instance()->createModel('Event');
        return $eventModel::findOne(['id' => $this->event_id]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'title' => AmosEvents::t('amosevents', '#name'),
            'position' => AmosEvents::t('amosevents', 'Position'),
        ]);
    }

}