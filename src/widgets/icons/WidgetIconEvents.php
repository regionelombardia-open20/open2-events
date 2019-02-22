<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\events\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconEvents
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEvents extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosEvents::t('amosevents', 'Events'));
        $this->setDescription(AmosEvents::t('amosevents', 'Allow the user to modify the Events entity'));
        $this->setIcon('calendar');
        $this->setUrl(['/events']);
        $this->setCode('EVENTS');
        $this->setModuleName('events');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-lightPrimary'
        ]));
        $count = $this->makeBulletCount();
        $this->setBulletCount($count);
    }

    /**
     * Make the number to set in the bullet count.
     */
    public function makeBulletCount()
    {
        $widgetAll = new WidgetIconEventOwnInterest();
        $widgetCreatedBy = new WidgetIconEventsCreatedBy();
        $count = $widgetAll->makeBulletCount() + $widgetCreatedBy->makeBulletCount();
        return $count;
    }
}
