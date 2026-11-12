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
use open20\amos\events\models\Event;
use open20\amos\events\rules\AgidEventPublishRule;
use open20\amos\events\rules\AgidEventToPublishRule;
use open20\amos\events\rules\EventsUpdateRule;
use open20\amos\events\rules\workflow\EventsToValidateWorkflowRule;
use yii\rbac\Permission;

/**
 * Class m201115_235449_modify_agid_event_publication_permission
 */
class m201115_235449_modify_agid_event_publication_permission extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => AgidEventPublishRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola pubblicazione eventi AGID',
                'ruleName' => AgidEventPublishRule::className(),
                'parent' => [
                    'EVENTS_CREATOR'
                ],
                'children' => [
                    Event::EVENTS_WORKFLOW_STATUS_PUBLISHED
                ]
            ],
            [
                'name' => AgidEventToPublishRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola richiesta pubblicazione eventi AGID',
                'ruleName' => AgidEventToPublishRule::className(),
                'parent' => [
                    EventsUpdateRule::className(),
                    EventsToValidateWorkflowRule::className()
                ],
                'children' => [
                    Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST
                ]
            ],
            [
                'name' => Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST,
                'update' => true,
                'newValues' => [
                    'removeParents' => [
                        EventsUpdateRule::className(),
                        EventsToValidateWorkflowRule::className()
                    ]
                ]
            ]
        ];
    }
}
