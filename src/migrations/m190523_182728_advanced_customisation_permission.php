<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\events\migrations
 * @category   CategoryName
 */

use open20\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

class m190523_182728_advanced_customisation_permission extends AmosMigrationPermissions
{

    /**
     * Use this function to map permissions, roles and associations between permissions and roles. If you don't need to
     * to add or remove any permissions or roles you have to delete this method.
     */
    protected function setAuthorizations()
    {
        $this->authorizations = [
            [
                'name' => 'ADVANCED_CUSTOMIZE_EVENTS',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission to advanced customize events',
                'ruleName' => null,
            ],
        ];
    }
}
