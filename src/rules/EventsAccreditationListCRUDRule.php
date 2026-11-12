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
use open20\amos\core\record\Record;
use open20\amos\events\AmosEvents;
use open20\amos\events\models\Event;
use open20\amos\events\models\EventAccreditationList;

/**
 * Class EventsAccreditationListCRUDRule
 * @package open20\amos\events\rules
 */
class EventsAccreditationListCRUDRule extends \open20\amos\core\rules\BasicContentRule
{
    public $name = 'EventsAccreditationListCRUDRule';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var Record $model */
            $model = $params['model'];
            if (!$model->id) {
                $post = \Yii::$app->getRequest()->post();
                $get = \Yii::$app->getRequest()->get();
                if (isset($get['id'])) {
                    $model = $this->instanceModel($model, $get['id']);
                } elseif (isset($post['id'])) {
                    $model = $this->instanceModel($model, $post['id']);
                } elseif (array_key_exists('eid', $get)) {
                    /** @var Event $eventModel */
                    $eventModel = AmosEvents::instance()->createModel('Event');
                    $model = $eventModel::findOne(['id' => $get['eid']]);
                }
            }
            return $this->ruleLogic($user, $item, $params, $model);
        }

        return false;
    }

    /**
     * Rule to Read Community
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        if ($model instanceof Event) {
            $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->community_id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
            if (!empty($communityUserMm)) {
                return true;
            }
        } elseif ($model instanceof EventAccreditationList) {
            $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->event_id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
            if (!empty($communityUserMm)) {
                return true;
            }
        }

        return false;
    }
}
