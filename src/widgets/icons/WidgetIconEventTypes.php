<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
 */

namespace lispa\amos\events\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconEventTypes
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEventTypes extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosEvents::t('amosevents', 'Event Types'));
        $this->setDescription(AmosEvents::t('amosevents', 'Allow the user to modify the EventType entity'));
        $this->setIcon('calendar');
        $this->setUrl(['/events/event-type/index']);
        $this->setCode('EVENT_TYPE');
        $this->setModuleName('events');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ]));
    }
}
