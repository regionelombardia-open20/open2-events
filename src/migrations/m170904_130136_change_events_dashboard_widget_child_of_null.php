<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWidgets;

/**
 * Class m170904_130136_change_events_dashboard_widget_child_of_null
 */
class m170904_130136_change_events_dashboard_widget_child_of_null extends AmosMigrationWidgets
{
    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'child_of' => null,
                'update' => true
            ]
        ];
    }
}
