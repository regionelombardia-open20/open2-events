<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\widgets\graphics
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

namespace open20\amos\events\widgets\graphics;

use open20\amos\core\widget\WidgetGraphic;
use open20\amos\events\AmosEvents;
use open20\amos\events\models\search\EventSearch;
use open20\amos\notificationmanager\base\NotifyWidgetDoNothing;

/**
 * Class WidgetGraphicsCalendarEvents
 * @package open20\amos\events\widgets\graphics
 */
class WidgetGraphicsCalendarEvents extends WidgetGraphic
{
    /**
     * @var int Numero eventi visualizzati
     */
    const NUMBER_EVENTS = 5;

    /**
     * @var string ORDER_EVENTS ordimento event Carousel
     */
    const ORDER_EVENTS = 'begin_date_hour DESC';

    /**
     * @inheritdoc
     */
    public function init()
    {

        parent::init();

        $this->setLabel(AmosEvents::tHtml('amosevents', 'Events'));
        $this->setDescription(AmosEvents::t('amosevents', 'Elenca gli ultimi Eventi'));
    }

    /**
     * @inheritdoc
     */
    public function getHtml()
    {

        /** @var EventSearch $search */
        $search = AmosEvents::instance()->createModel('EventSearch');
        $search->setNotifier(new NotifyWidgetDoNothing());
        $events = $listEvents = $search->ultimeEvents($_GET, self::NUMBER_EVENTS);
        $eventsForCarousel = $search->ultimeEventsQuery($_GET, self::NUMBER_EVENTS)->orderBy(self::ORDER_EVENTS)->limit(self::NUMBER_EVENTS)->all();

        $viewToRender = 'agid_calendary';

        $moduleLayout = \Yii::$app->getModule('layout');

        if (is_null($moduleLayout)) {
            $viewToRender .= '_old';
        }


        return $this->render($viewToRender, [
            'listEvents' => $listEvents,
            'events' => $events,
            'eventsForCarousel' => $eventsForCarousel,
            'widget' => $this,
            'toRefreshSectionId' => 'widgetGraphicLatestEvents',
            'numEvents' => self::NUMBER_EVENTS,
            'orderEvents' => self::ORDER_EVENTS
        ]);
    }
}
