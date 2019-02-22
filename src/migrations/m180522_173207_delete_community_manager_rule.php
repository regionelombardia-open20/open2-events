<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\news\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m170914_135007_add_validatore_news_to_validator_role
 */
class m180522_173207_delete_community_manager_rule extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\events\rules\DeleteCommunityManagerEventsRule::className(),
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Regola per cancellare una evento se sei CM',
                'ruleName' => \lispa\amos\events\rules\DeleteCommunityManagerEventsRule::className(),
                'parent' => ['EVENTS_CREATOR'],
                'children' => ['EVENT_DELETE']
            ]
        ];
    }
}
