<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\partnershipprofiles\rules
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

use open20\amos\community\models\Community;
use open20\amos\community\models\CommunityUserMm;
use open20\amos\core\record\Record;
use open20\amos\events\AmosEvents;
use open20\amos\events\models\Event;

/**
 * Class EventsUpdateRule
 * @package open20\amos\events\rules
 */
class EventsUpdateRule extends \open20\amos\core\rules\BasicContentRule
{
    public $name = 'EventsUpdate';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var Record $model */
            $model = $params['model'];

            /** @var AmosEvents $eventsModule */
            $eventsModule = AmosEvents::instance();
            if (is_null($eventsModule)) {
                return false;
            }

            if ($model::className() == $eventsModule->model('Event')) {

                if (!$model->id) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($model, $get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($model, $post['id']);
                    } elseif (array_key_exists('eid', $get)) {
                        /** @var Event $eventModel */
                        $eventModel = $eventsModule->createModel('Event');
                        $event = $eventModel::findOne(['id' => $get['eid']]);
                        if ($event) {
                            $model = $event;
                        }
                    } else {
                        return false;
                    }
                }

                return $this->ruleLogic($user, $item, $params, $model);

            } elseif ($model::className() == Community::className()) {

                if (!$model->id) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($model, $get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($model, $post['id']);
                    } else {
                        return false;
                    }
                }

                return $this->ruleLogicForCommunity($user, $item, $params, $model);

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
        $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->community_id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
        if (empty($communityUserMm)) {
            return false;
        }

        return true;
    }

    /**
     * Rule to Read Community
     * @inheritdoc
     */
    public function ruleLogicForCommunity($user, $item, $params, $model)
    {
        $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
        if (empty($communityUserMm)) {
            return false;
        }
        return true;
    }
}
