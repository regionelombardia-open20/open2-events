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

/**
 * Class m170317_154222_events_wizflow_permissions
 */
class m170317_154222_events_wizflow_permissions extends AmosMigrationPermissions
{
    /**
     * Use this function to map permissions, roles and associations between permissions and roles. If you don't need to
     * to add or remove any permissions or roles you have to delete this method.
     */
    protected function setAuthorizations()
    {
        $this->authorizations = [
            [
                'name' => 'EventCreationWizardWorkflow/INTRODUCTION',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Wizflow step permission: introduction',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR']
            ],
            [
                'name' => 'EventCreationWizardWorkflow/DESCRIPTION',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Wizflow step permission: description',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR']
            ],
            [
                'name' => 'EventCreationWizardWorkflow/ORGANIZATIONALDATA',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Wizflow step permission: organizational data',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR']
            ],
            [
                'name' => 'EventCreationWizardWorkflow/PUBLICATION',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Wizflow step permission: publication',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR']
            ],
            [
                'name' => 'EventCreationWizardWorkflow/SUMMARY',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Wizflow step permission: summary',
                'ruleName' => null,
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR']
            ]
        ];
    }
}
