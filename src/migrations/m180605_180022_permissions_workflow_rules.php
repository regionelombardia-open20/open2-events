<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m170719_122922_permissions_community
 */
class m180605_180022_permissions_workflow_rules extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\events\rules\workflow\EventsToValidateWorkflowRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check',
                'ruleName' =>  \lispa\amos\events\rules\workflow\EventsToValidateWorkflowRule::className(),
                'parent' => ['EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR', 'PLATFORM_EVENTS_VALIDATOR', 'EventValidate', 'EVENTS_VALIDATOR']
            ],
            [
                'name' => 'EventWorkflow/PUBLISHREQUEST',
                'update' => true,
                'newValues' => [
                    'addParents' => [
                        \lispa\amos\events\rules\workflow\EventsToValidateWorkflowRule::className(),
                    ],
                    'removeParents' => [
                        'EVENTS_ADMINISTRATOR', 'EVENTS_CREATOR', 'PLATFORM_EVENTS_VALIDATOR', 'EventValidate', 'EVENTS_VALIDATOR'
                    ]
                ],
            ],

        ];
    }
}
