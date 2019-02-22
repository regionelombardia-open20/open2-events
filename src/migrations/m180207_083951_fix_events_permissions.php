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

/**
 * Class m180207_083951_fix_events_permissions
 */
class m180207_083951_fix_events_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\events\widgets\icons\WidgetIconEventOwnInterest::className(),
                'update' => true,
                'newValues' => [
                    'addParents' => ['EVENTS_READER'],
                    'removeParents' => ['BASIC_USER']
                ]
            ]
        ];
    }
}
