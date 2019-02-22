<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m170412_084900_add_permission_event_validate
 */
class m170412_084900_add_permission_event_validate extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'EventValidate',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission to validate an event with cwh query',
                'ruleName' => \lispa\amos\core\rules\ValidatorUpdateContentRule::className(),
                'parent' => ['EVENTS_VALIDATOR', 'PLATFORM_EVENTS_VALIDATOR']
            ],
            [
                'name' => 'EVENT_UPDATE',
                'update' => true,
                'newValues' => [
                    'addParents' => ['EventValidate'],
                    'removeParents' => ['EVENTS_VALIDATOR', 'PLATFORM_EVENTS_VALIDATOR']
                ]
            ]
        ];
    }
}
