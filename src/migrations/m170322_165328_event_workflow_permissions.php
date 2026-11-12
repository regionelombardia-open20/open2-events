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
use yii\rbac\Permission;

class m170322_165328_event_workflow_permissions extends AmosMigrationPermissions
{
    const EVENT_WORKFLOW_NAME = 'EventWorkflow';

    /**
     * Use this function to map permissions, roles and associations between permissions and roles. If you don't need to
     * to add or remove any permissions or roles you have to delete this method.
     */
    protected function setAuthorizations()
    {
        $this->authorizations = [
            [
                'name' => self::EVENT_WORKFLOW_NAME . '/DRAFT',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Workflow status permission: Draft',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR', 'EVENTS_VALIDATOR', 'PLATFORM_EVENTS_VALIDATOR']
            ],
            [
                'name' => self::EVENT_WORKFLOW_NAME . '/PUBLISHREQUEST',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Workflow status permission: Publish request',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR', 'EVENTS_VALIDATOR', 'PLATFORM_EVENTS_VALIDATOR']
            ],
            [
                'name' => self::EVENT_WORKFLOW_NAME . '/PUBLISHED',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Workflow status permission: Published',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_VALIDATOR', 'PLATFORM_EVENTS_VALIDATOR']
            ]
        ];
    }
}
