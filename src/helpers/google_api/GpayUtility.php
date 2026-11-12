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

/**
 * Created by PhpStorm.
 * User: michele.lafrancesca
 * Date: 07/10/2020
 * Time: 15:52
 */

namespace open20\amos\events\helpers\google_api;


use open20\amos\events\models\Event;
use open20\amos\events\models\EventInvitation;

class GpayUtility
{
    /**
     * @param $id
     * @return bool
     */
    public static function createUpdateTicketClassGpay($id)
    {
        $event = Event::findOne($id);
        $services = new Services(['event_id' => $id]);

        $classId = $services->getTicketClassId($event);
        $objectId = $services->generateTicketObjectId($id);
        $skinnyJwt = $services->createUpdateSkinnyJwt($classId, $objectId);
//        pr($skinnyJwt);
//        die;
        if($skinnyJwt != null){
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public static function updateTicketObjectGpay($id, $user_id)
    {
        $event = Event::findOne($id);
        $verticalType = VerticalType::EVENTTICKET;
        $services = new Services(['event_id' => $id]);
        $invitation = EventInvitation::findOne(
            [
                'event_id' => $id,
                'user_id' => $user_id
            ]
        );

        $classId = $services->getTicketClassId($event);
        $objectId = $services->getTicketObjectId($invitation);
        $skinnyJwt = $services->updateCreateTicketObject($verticalType, $classId, $objectId, $user_id);

        if($skinnyJwt != null){
            return true;
        }
        return false;
    }


}