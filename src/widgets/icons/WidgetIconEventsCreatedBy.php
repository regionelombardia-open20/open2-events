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
use lispa\amos\events\models\Event;
use lispa\amos\events\models\search\EventSearch;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconEventsCreatedBy
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEventsCreatedBy extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosEvents::t('amosevents', 'Events created by me'));
        $this->setDescription(AmosEvents::t('amosevents', 'Events created by me'));
        $this->setIcon('calendar');
        $this->setUrl(['/events/event/created-by']);
        $this->setCode('EVENT_CREATED_BY');
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
        $modelSearch = new EventSearch();
        $dataProvider = $modelSearch->searchCreatedBy([]);
        $count = $dataProvider->query->andWhere([Event::tableName() . '.status' => Event::EVENTS_WORKFLOW_STATUS_DRAFT])->count();
        return $count;
    }
}
