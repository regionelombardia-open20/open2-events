<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\controllers
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

namespace open20\amos\events\controllers;

use open20\amos\events\AmosEvents;
use open20\amos\events\models\Event;
use open20\amos\events\models\EventCalendarsSlotsBooked;
use open20\amos\events\models\search\EventCalendarsSlotsSearch;
use open20\amos\events\utility\EventMailUtility;
use open20\amos\events\utility\EventsUtility;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Class EventCalendarsSlotsController
 * This is the class for controller "EventCalendarsSlotsController".
 * @package open20\amos\events\controllers
 */
class EventCalendarsSlotsController extends \open20\amos\events\controllers\base\EventCalendarsSlotsController
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'book-slot',
                            'unbook-slot',
                            'my-booking',
                            'booked-users'
                        ],
                        'roles' => ['@']
                    ],


                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get']
                ]
            ]
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionBookSlot($id, $url = null, $affiliation = null, $cellphone = null, $redirectUrl = null)
    {
        $this->model = $this->findModel($id);
        $calendar = $this->model->eventCalendars;
        $isParticipant = EventsUtility::isEventParticipant($this->model->eventCalendars->event->id, \Yii::$app->user->id);
        if (!$isParticipant) {
            throw new ForbiddenHttpException(AmosEvents::t('amosevents',"Devi essere registrato all'evento."));
        }

        $this->model->getEventCalendarsSlotsBooked()->andWhere(['user_id' => \Yii::$app->user->id])->one();

        if ($this->model->canBook()) {
            $bookedSlot = new EventCalendarsSlotsBooked();
            $bookedSlot->event_calendars_slots_id = $this->model->id;
            $bookedSlot->user_id = \Yii::$app->user->id;
            $bookedSlot->booked_at = date('Y-m-d H:i:s');
            $bookedSlot->affiliation = $affiliation;
            $bookedSlot->cellphone = $cellphone;
            $bookedSlot->save(false);
            EventMailUtility::sendEmailSlotBooked($bookedSlot);
            EventMailUtility::sendEmailPartnerSlotBooked($bookedSlot);

            \Yii::$app->session->addFlash('success', AmosEvents::t('amosevents', 'Hai prenotato correttamente questo slot'));

        } else {
            \Yii::$app->session->addFlash('danger', AmosEvents::t('amosevents', 'Non puoi prenotare questo slot'));
        }
        if($redirectUrl){
            return $this->redirect($redirectUrl);
        }
        return $this->redirect(['/events/event-calendars/view', 'id' => $calendar->id, 'url' => $url]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUnbookSlot($id, $url = null, $redirectUrl = null)
    {
        $this->model = $this->findModel($id);
        $calendar = $this->model->eventCalendars;
        $booked = $this->model->getEventCalendarsSlotsBooked()->andWhere(['user_id' => \Yii::$app->user->id])->one();
        if (!empty($booked)) {
            EventMailUtility::sendEmailSlotUnbooked($booked);
            EventMailUtility::sendEmailPartnerSlotUnbooked($booked);
            $booked->delete();

            \Yii::$app->session->addFlash('success', AmosEvents::t('amosevents', 'Hai annullato correttamente la prenotazione a questo questo slot'));
        } else {
            \Yii::$app->session->addFlash('danger', AmosEvents::t('amosevents', 'Questo slot è già vuoto'));
        }
        if($redirectUrl){
            return $this->redirect($redirectUrl);
        }
        return $this->redirect(['/events/event-calendars/view', 'id' => $calendar->id, 'url' => $url]);
    }

    /**
     * @param $eventId
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMyBooking($eventId)
    {
        $this->setUpLayout('list');
        /** @var Event $eventModel */
        $eventModel = $this->eventsModule->createModel('Event');
        /** @var Event $event */
        $event = $eventModel::findOne($eventId);
        /** @var EventCalendarsSlotsSearch $modelSearch */
        $modelSearch = $this->eventsModule->createModel('EventCalendarsSlotsSearch');
        $modelSearch->event = $eventId;
        $dataProvider = $modelSearch->mySlotsAllSearch([]);

        return $this->render('my-booking', [
            'event' => $event,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionBookedUsers($id){
        $this->model = $this->findModel($id);
        $calendar = $this->model->eventCalendars;
        $dataProvider = new ActiveDataProvider([
            'query' => $this->model->getEventCalendarsSlotsBooked()
        ]);

        return $this->render('booked-users', ['model' => $this->model,
            'calendar' => $calendar,
            'dataProvider' => $dataProvider,
            'event' => $calendar->event
        ]);
    }


}
