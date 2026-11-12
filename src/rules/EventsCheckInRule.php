<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\rules
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

namespace open20\amos\events\rules;

use open20\amos\community\models\CommunityUserMm;
use open20\amos\events\AmosEvents;
use open20\amos\events\models\Event;
use yii\rbac\Rule;

/**
 * Class EventsCheckInRule
 * @package open20\amos\events\rules
 */
class EventsCheckInRule extends Rule
{
    public $name = 'EventsCheckIn';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $get = \Yii::$app->getRequest()->get();
        if (array_key_exists('eid', $get)) {
            /** @var AmosEvents $eventsModule */
            $eventsModule = AmosEvents::instance();
            if (is_null($eventsModule)) {
                return false;
            }
            /** @var Event $eventModel */
            $eventModel = $eventsModule->createModel('Event');
            $event = $eventModel::findOne(['id' => $get['eid']]);
            if ($event) {
                return $this->ruleLogic($user, $item, $params, $event);
            }
        } elseif (array_key_exists('communityId', $get)) {
            /** @var AmosEvents $eventsModule */
            $eventsModule = AmosEvents::instance();
            if (is_null($eventsModule)) {
                return false;
            }
            /** @var Event $eventModel */
            $eventModel = $eventsModule->createModel('Event');
            $event = $eventModel::findOne(['community_id' => $get['communityId']]);
            if ($event) {
                return $this->ruleLogic($user, $item, $params, $event);
            }
        }
        return false;
    }

    /**
     * Rule to Read Community
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->community_id,
            'role' => [Event::EVENTS_CHECK_IN, Event::EVENT_MANAGER]])
            ->andWhere(['user_id' => $user])->one();
        if (!empty($communityUserMm)) {
            return true;
        }
        return false;
    }
}
