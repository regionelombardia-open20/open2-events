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
use lispa\amos\dashboard\models\AmosWidgets;

/**
 * Class m170315_135851_init_events_widgets
 */
class m170315_135851_init_events_widgets extends AmosMigrationWidgets
{
    const MODULE_NAME = 'events';

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'default_order' => 10
            ],
            [
                'classname' => \lispa\amos\events\widgets\icons\WidgetIconEventsCreatedBy::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'default_order' => 20
            ],
            [
                'classname' => \lispa\amos\events\widgets\icons\WidgetIconEventTypes::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'default_order' => 30
            ],
            [
                'classname' => \lispa\amos\events\widgets\icons\WidgetIconEventsToPublish::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'default_order' => 40
            ],
            [
                'classname' => \lispa\amos\events\widgets\icons\WidgetIconEventsManagement::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
                'default_order' => 50
            ]
        ];
    }
}
