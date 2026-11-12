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

use open20\amos\core\migration\AmosMigrationWorkflow;
use yii\helpers\ArrayHelper;

/**
 * Class m170322_165316_event_workflow
 */
class m170322_165316_event_workflow extends AmosMigrationWorkflow
{
    const EVENT_WORKFLOW_NAME = 'EventWorkflow';

    /**
     * @inheritdoc
     */
    protected function setWorkflow()
    {
        return ArrayHelper::merge(
            parent::setWorkflow(),
            $this->workflowConf(),
            $this->workflowStatusConf(),
            $this->workflowTransitionsConf(),
            $this->workflowMetadataConf()
        );
    }

    /**
     * In this method there are the new workflow configuration.
     * @return array
     */
    private function workflowConf()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW,
                'id' => self::EVENT_WORKFLOW_NAME,
                'initial_status_id' => 'DRAFT'
            ]
        ];
    }

    /**
     * In this method there are the new workflow statuses configurations.
     * @return array
     */
    private function workflowStatusConf()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'DRAFT',
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'label' => 'Draft',
                'sort_order' => '0'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'PUBLISHREQUEST',
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'label' => 'Publish request',
                'sort_order' => '1'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'PUBLISHED',
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'label' => 'Published',
                'sort_order' => '2'
            ]
        ];
    }

    /**
     * In this method there are the new workflow status transitions configurations.
     * @return array
     */
    private function workflowTransitionsConf()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'start_status_id' => 'DRAFT',
                'end_status_id' => 'PUBLISHREQUEST'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'start_status_id' => 'PUBLISHREQUEST',
                'end_status_id' => 'PUBLISHED'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'start_status_id' => 'DRAFT',
                'end_status_id' => 'PUBLISHED'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'start_status_id' => 'PUBLISHED',
                'end_status_id' => 'DRAFT'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'start_status_id' => 'PUBLISHREQUEST',
                'end_status_id' => 'DRAFT'
            ]
        ];
    }

    /**
     * In this method there are the new workflow metadata configurations.
     * @return array
     */
    private function workflowMetadataConf()
    {
        return [
            // "Draft" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'DRAFT',
                'key' => 'class',
                'value' => 'btn btn-navigation-primary'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'DRAFT',
                'key' => 'description',
                'value' => 'Event editing'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'DRAFT',
                'key' => 'label',
                'value' => 'Updating'
            ],

            // "Publish request" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'class',
                'value' => 'btn btn-navigation-primary'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'description',
                'value' => 'It puts an event in publish request'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'label',
                'value' => 'Publish request'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'message',
                'value' => 'Do you want to set the publish request status?'
            ],

            // "Published" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'class',
                'value' => 'btn btn-navigation-primary'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'description',
                'value' => 'The event will be published'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'label',
                'value' => 'Published'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'message',
                'value' => 'Do you want to publish the event?'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::EVENT_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'order',
                'value' => '1'
            ]
        ];
    }
}
