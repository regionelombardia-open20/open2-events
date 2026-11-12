<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\models
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

/**
 * Class EventParticipantCompanion
 *
 * This is the model class for table "event_participant_companion".
 *
 * @property integer $event_id
 * @property \open20\amos\events\models\Event $event
 * @property-read string $nomeCognome
 * @property-read string $userEmail
 *
 * @package open20\amos\events\models
 */
class EventParticipantCompanion extends \open20\amos\events\models\base\EventParticipantCompanion
{
    public $event_id;

    /**
     * @return Event|null
     */
    public function getEvent()
    {
        /** @var Event $eventModel */
        $eventModel = $this->eventsModule->createModel('Event');
        return $eventModel::findOne(['id' => $this->event_id]);
    }

    /**
     * This method returns the name and surname of the user invited.
     * If the invitation is linked to an user, the method returns the name and surname of the user profile.
     * @return string
     */
    public function getNomeCognome()
    {
        $user = $this->user;
        if (!is_null($user)) {
            $nomeCognome = $user->userProfile->nomeCognome;
        } else {
            $nomeCognome = $this->nome . ' ' . $this->cognome;
        }
        return $nomeCognome;
    }

    /**
     * This method returns the email of the companion invited.
     * If the companion is linked to an user, the method returns the email of the user profile.
     * @return string
     */
    public function getUserEmail()
    {
        $user = $this->user;
        if (!is_null($user)) {
            $email = $user->email;
        } else {
            $email = $this->email;
        }
        return $email;
    }
}
