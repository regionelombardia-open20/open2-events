<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\events
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

namespace open20\amos\events\events;

use open20\amos\community\models\CommunityUserMm;
use open20\amos\core\controllers\CrudController;
use open20\amos\core\user\User;
use open20\amos\core\utilities\Email;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;

/**
 * Class EventsWorkflowEvent
 * @package open20\amos\events\events
 */
class EventsWorkflowEvent
{
    /**
     * @param Event $yiiEvent
     * @return bool
     */
    public function sendValidationRequest(Event $yiiEvent)
    {
        /** @var \open20\amos\events\models\Event $event */
        $event = $yiiEvent->data;
        if (is_null($event->community_id)) {
            return true;
        }

        // Default email values
        $from = User::findOne(Yii::$app->getUser()->id)->email;
        $to = [];
        $subject = null;
        $text = null;
        $files = [];
        $bcc = [];
        $params = null;
        $priority = 0;
        $use_queue = true;

        $user = User::findOne($event->created_by);

        // Populate TO
        if(!empty($event->validatori)) {
            $validatori = [];
            if(!is_array($event->validatori)){
                $validatori[$event->validatori] = $event->validatori;
            }
            else {
                $validatori = $event->validatori;
            }
            foreach ($validatori as $key => $value) {
                $pos = strrpos($value, 'user');
                if ($pos !== false) { // Found USER VALIDATOR
                    $userId = str_replace('user-', '', $value);
                    $user = User::findOne($userId);
                    $to[] = $user->email;
                } else {
                    $pos = strrpos($value, 'community');
                    if ($pos !== false) { // Found COMMUNITY VALIDATOR
                        $commuityId = str_replace('community-', '', $value); // TODO In the future could be useful
                        $communityUserMm = new CommunityUserMm();
                        $tmp = $communityUserMm->getCommunityManagerMailList($event->community_id);
                        $to = ArrayHelper::merge($to, $tmp);
                    }
                }
            }
        }

        /** @var CrudController $controller */
        $controller = \Yii::$app->controller;
        $vendorAlias = Yii::getAlias('@vendor');
        $controller->setViewPath($vendorAlias . DIRECTORY_SEPARATOR .
            'open20' . DIRECTORY_SEPARATOR .
            'amos-events' . DIRECTORY_SEPARATOR .
            'src' . DIRECTORY_SEPARATOR .
            'views' . DIRECTORY_SEPARATOR .
            'email');


        // Populate SUBJECT
        $subject = $controller->renderMailPartial(
            'validation_request_subject',
            [
                'event' => $event
            ]
        );

        // Populate TEXT
        $text = $controller->renderMailPartial(
            'validation_request_text',
            [
                'event' => $event,
                'user' => $user
            ]
        );

        // Populate BCC
        $bcc[] = User::findOne(Yii::$app->getUser()->id)->email;

        // Populate PARAMS
        /* NOT YET IMPLEMENTED, RESERVED FOR FUTURE USE */

        // SEND EMAIL
        $ok = Email::sendMail(
            $from,
            $to,
            $subject,
            $text,
            $files,
            $bcc,
            $params,
            $priority,
            $use_queue
        );

        return $ok;
    }

    /**
     * @param Event $yiiEvent
     * @return bool
     */
    public function eventPublicationOperations(Event $yiiEvent)
    {
        /** @var \open20\amos\events\models\Event $event */
        $event = $yiiEvent->data;
        if (is_null($event)) {
            return false;
        }

        $loggedUser = User::findOne(Yii::$app->getUser()->getId());
        if (is_null($loggedUser)) {
            return false;
        }

        $creatorUser = User::findOne($event->created_by);
        if (is_null($creatorUser)) {
            return false;
        }

        /** @var CrudController $controller */
        $controller = \Yii::$app->controller;

        $vendorAlias = Yii::getAlias('@vendor');
        $controller->setViewPath($vendorAlias . DIRECTORY_SEPARATOR .
            'open20' . DIRECTORY_SEPARATOR .
            'amos-events' . DIRECTORY_SEPARATOR .
            'src' . DIRECTORY_SEPARATOR .
            'views' . DIRECTORY_SEPARATOR .
            'email');

        // Populate SUBJECT
        $subject = $controller->renderMailPartial(
            'publication_subject'
        );

        // Populate TEXT
        $text = $controller->renderMailPartial(
            'publication_text',
            [
                'event' => $event
            ]
        );

        $from = $loggedUser->email;
        $to = [$creatorUser->email];
        $files = [];
        $bcc = [$loggedUser->email];
        $params = null;
        $priority = 0;
        $use_queue = true;

        $ok = Email::sendMail(
            $from,
            $to,
            $subject,
            $text,
            $files,
            $bcc,
            $params,
            $priority,
            $use_queue
        );

        return $ok;
    }
}
