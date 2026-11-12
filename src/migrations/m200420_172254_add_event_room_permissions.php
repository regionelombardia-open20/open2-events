<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\migrations
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
use open20\amos\events\rules\EventRoomsRule;
use open20\amos\events\widgets\icons\WidgetIconEventRooms;
use yii\helpers\ArrayHelper;
use yii\rbac\Permission;

/**
 * Class m200420_172254_add_event_room_permissions
 */
class m200420_172254_add_event_room_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return ArrayHelper::merge(
            $this->setPluginRoles(),
            $this->setModelPermissions(),
            $this->setWidgetsPermissions()
        );
    }

    private function setPluginRoles()
    {
        return [
            [
                'name' => 'EVENTS_ROOMS_MANAGER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Role to manage EventRoom',
                'ruleName' => EventRoomsRule::className(),
                'parent' => ['EVENTS_ADMINISTRATOR']
            ]
        ];
    }

    private function setModelPermissions()
    {
        return [
            [
                'name' => 'EVENTROOM_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Create permission for model EventRoom',
                'parent' => ['EVENTS_ROOMS_MANAGER']
            ],
            [
                'name' => 'EVENTROOM_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Read permission for model EventRoom',
                'parent' => ['EVENTS_ROOMS_MANAGER']
            ],
            [
                'name' => 'EVENTROOM_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Update permission for model EventRoom',
                'parent' => ['EVENTS_ROOMS_MANAGER']
            ],
            [
                'name' => 'EVENTROOM_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Delete permission for model EventRoom',
                'parent' => ['EVENTS_ROOMS_MANAGER']
            ]
        ];
    }

    private function setWidgetsPermissions()
    {
        $prefixStr = 'Permissions for the dashboard for the widget ';
        return [
            [
                'name' => WidgetIconEventRooms::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconEventRooms',
                'parent' => ['EVENTS_ROOMS_MANAGER']
            ]
        ];
    }
}
