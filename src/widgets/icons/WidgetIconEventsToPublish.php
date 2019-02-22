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
 * Class WidgetIconEventsToPublish
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEventsToPublish extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosEvents::t('amosevents', 'Events to publish'));
        $this->setDescription(AmosEvents::t('amosevents', 'Events to publish'));
        $this->setIcon('calendar');
        $this->setUrl(['/events/event/to-publish']);
        $this->setCode('EVENT_TO_PUBLISH');
        $this->setModuleName('events');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ]));
    }
}
