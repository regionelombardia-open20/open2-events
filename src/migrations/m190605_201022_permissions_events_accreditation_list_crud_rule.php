<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\community\migrations
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
 * Class m190605_201022_permissions_events_accreditation_list_crud_rule
 */
class m190605_201022_permissions_events_accreditation_list_crud_rule extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'EVENTACCREDITATIONLIST_MANAGER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Manager for events event accreditation lists',
                'ruleName' => null,
                'parent' => ['EVENTS_READER']
            ],
            [
                'name' => \open20\amos\events\rules\EventsAccreditationListCRUDRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di effettuare operazioni crud nelle liste accreditamento di eventi in cui il partecipante è events_manager',
                'ruleName' => \open20\amos\events\rules\EventsAccreditationListCRUDRule::className(),
                'children' => [
                    'EVENTACCREDITATIONLIST_CREATE',
                    'EVENTACCREDITATIONLIST_READ',
                    'EVENTACCREDITATIONLIST_UPDATE',
                    'EVENTACCREDITATIONLIST_DELETE',
                ],
                'parent' => ['EVENTACCREDITATIONLIST_MANAGER'],
            ],
        ];
    }
}
