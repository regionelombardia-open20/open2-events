<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\events\widgets\graphics
 * @category   CategoryName
 */

namespace open20\amos\events\widgets\graphics;

use DateTime;
use yii\db\Query;
use open20\amos\events\AmosEvents;
use open20\amos\events\models\Event;
use open20\amos\core\widget\WidgetGraphic;
use open20\amos\events\models\search\EventSearch;
use open20\amos\notificationmanager\base\NotifyWidgetDoNothing;


/**
 * Class WidgetGraphicsCarouselEvents
 * @package open20\amos\events\widgets\graphics
 */
class WidgetGraphicsCarouselEvents extends WidgetGraphic
{

    /**
     * @inheritdoc
     */
    public function init()
    {

        parent::init();

        $this->setLabel(AmosEvents::tHtml('amosevents', 'Events'));
        $this->setDescription(AmosEvents::t('amosevents', 'Elenca gli ultimi Eventi'));

        setlocale(LC_TIME, 'ita', 'it_IT.utf8');
    }


    /**
     * Method for extracting and displaying events in the fronend carousel
     * 
     * @param int $number_of_events
     * @param boolean $current_mounth 
     */
    public function getHtml($number_of_events = null, $current_mounth = true)
    {
        // set view 
        $viewToRender = 'agid_carousel_events';

        $moduleLayout = \Yii::$app->getModule('layout');
        if (is_null($moduleLayout)) {
            $viewToRender .= '_old';
        }


        // get current date 
        $current_date = new DateTime();
        $current_date->setTime(0, 0);
        $last_month_date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m')+1, 0, date('Y-m-d H:i:s')));

        // get all event dates starting today
        $list_events = Event::find()
                        ->andWhere(['status' => 'EventWorkflow/PUBLISHED'])
                        ->andWhere(['in_evidenza' => '1'])
                        ->andWhere(['primo_piano' => '1'])
                        ->andWhere(['<=', 'begin_date_hour', $current_date->format('Y-m-d H:i:s') ])
                        ->andWhere(['>=', 'end_date_hour', $current_date->format('Y-m-d H:i:s') ])

                        ->orWhere([ '>=', 'begin_date_hour' , $current_date->format('Y-m-d H:i:s'),

                    ])->limit($number_of_events);

        // check if the events should be in the current month
        if( $current_mounth ){

            $list_events->andWhere(['=', 'YEAR(begin_date_hour)', $current_date->format('Y') ]);
            $list_events->andWhere(['=', 'MONTH(begin_date_hour)', $current_date->format('m') ]);

        }

        // order and get all events model
        $list_events = $list_events->orderBy([
                                        'begin_date_hour' => SORT_ASC 
                                    ])
                                    ->all();

        
        // create an array with events grouped by day
        $start_begin_date_hour = new DateTime($list_events[0]->begin_date_hour);
        $list_events_grouped = array();

        // riciclo la lista ed aggiungo gli eventi per i giorni che sussegono dalla data inizio alla data fine dell'evento

        // data inizio degli eventi oggi 
        $current_date_day = (int) $current_date->format('d');
        // data fine degli eventi ultimo giorno del mese
        $last_month_day = (int) date('d', mktime(0, 0, 0, date('m')+1, 0, date('Y')));

        for ($i=$current_date_day; $i<=$last_month_day; $i++) { 

            foreach ($list_events as $key => $event) {

                $begin_date_hour = new DateTime($event->begin_date_hour);
                $end_date_hour = new DateTime($event->end_date_hour);

                if( (null != $event->end_date_hour) && !empty($event->end_date_hour) ){

                    // controllo che data fine evento sia >= all'indice del giorno $i 
                    if( (intval($end_date_hour->format('d')) >= $i) && (intval($begin_date_hour->format('d')) <= $i) ){

                        $tmp = $current_date->format('Y-m') . '-' . $i;
                        $list_events_grouped[ $tmp ][] = $event;
                    }

                }else if((null == $event->end_date_hour) && empty($event->end_date_hour)){

                    // controllo che data fine evento sia >= all'indice del giorno $i 
                    if( (intval($end_date_hour->format('d')) >= $i) && (intval($begin_date_hour->format('d')) <= $i) ){

                        $tmp = $current_date->format('Y-m') . '-' . $i;
                        $list_events_grouped[ $tmp ][] = $event;
                        
                    }elseif( null == $event->end_date_hour && (intval($begin_date_hour->format('d')) == $i)){

                        $tmp = $current_date->format('Y-m') . '-' . $i;
                        $list_events_grouped[ $tmp ][] = $event;
                    }
                }
            }
        }
        

        return $this->render($viewToRender, [
            'list_events_grouped' => $list_events_grouped,
            'widget' => $this,
        ]);
    }

}

