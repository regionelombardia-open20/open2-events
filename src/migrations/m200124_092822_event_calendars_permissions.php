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

use open20\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;


/**
 * Class m200124_092822_event_calendars_permissions*/
class m200124_092822_event_calendars_permissions extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        $prefixStr = '';

        return [
            [
                'name' => 'EVENTCALENDARS_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di CREATE sul model EventCalendars',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],
            [
                'name' => 'EVENTCALENDARS_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di READ sul model EventCalendars',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],
            [
                'name' => 'EVENTCALENDARS_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di UPDATE sul model EventCalendars',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],
            [
                'name' => 'EVENTCALENDARS_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di DELETE sul model EventCalendars',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],

//------------------------------------------------
            [
                'name' => 'EVENTCALENDARSSLOTS_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di CREATE sul model EventCalendarsSlots',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR']
            ],
            [
                'name' => 'EVENTCALENDARSSLOTS_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di READ sul model EventCalendarsSlots',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],
            [
                'name' => 'EVENTCALENDARSSLOTS_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di UPDATE sul model EventCalendarsSlots',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],
            [
                'name' => 'EVENTCALENDARSSLOTS_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di DELETE sul model EventCalendarsSlots',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR','open20\amos\events\rules\EventsUpdateRule']
            ],

        ];
    }
}
