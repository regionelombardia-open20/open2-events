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
 * Class WidgetIconEventsManagement
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEventsManagement extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosEvents::t('amosevents', 'Events management'));
        $this->setDescription(AmosEvents::t('amosevents', 'Events management'));
        $this->setIcon('table');
        $this->setUrl(['/events/event/management']);
        $this->setCode('EVENT_MANAGEMENT');
        $this->setModuleName('events');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ]));
    }
}