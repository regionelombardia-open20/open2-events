<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\controllers
 * @category   CategoryName
 */

namespace lispa\amos\events\controllers;

use lispa\amos\admin\models\UserProfile;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\user\User;
use lispa\amos\core\utilities;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\Event;
use lispa\amos\events\models\EventLengthMeasurementUnit;
use lispa\amos\events\utility\EventsUtility;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class EventController
 * This is the class for controller "EventController".
 * @package lispa\amos\events\controllers
 */
class EventController extends base\EventController {

    /**
     * @var string $layout
     */
    public $layout = 'list';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                            [
                                'allow' => true,
                                'actions' => [
                                    'calculate-end-date-hour',
                                    'created-by',
                                    'get-event-by-id',
                                    'to-publish',
                                    'management',
                                    'validate',
                                    'reject',
                                    'own-interest'
                                ],
                                'roles' => ['EVENTS_ADMINISTRATOR']
                            ],
                            [
                                'allow' => true,
                                'actions' => [
                                    'own-interest'
                                ],
                                'roles' => ['EVENTS_READER']
                            ],
                            [
                                'allow' => true,
                                'actions' => [
                                    'calculate-end-date-hour',
                                    'created-by',
                                    'get-event-by-id',
                                ],
                                'roles' => ['EVENTS_CREATOR']
                            ],
                            [
                                'allow' => true,
                                'actions' => [
                                    'calculate-end-date-hour',
                                    'get-event-by-id',
                                    'to-publish',
                                    'validate',
                                    'reject',
                                ],
                                'roles' => ['EVENTS_VALIDATOR', 'PLATFORM_EVENTS_VALIDATOR', 'EventValidateOnDomain']
                            ],
                            [
                                'allow' => true,
                                'actions' => [
                                    'management',
                                ],
                                'roles' => ['EVENTS_MANAGER']
                            ],
                            [
                                'allow' => true,
                                'actions' => [
                                    'subscribe',
                                    'accept',
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
     * @return string
     */
    public function actionCreatedBy() {
        $this->setDataProvider($this->modelSearch->searchCreatedBy(Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(AmosEvents::t('amosevents', 'Created by me'));
    }

    /**
     * @return string
     */
    public function actionCalculateEndDateHour() {
        $retval = [];
        if (Yii::$app->getRequest()->getIsAjax()) {
            $post = Yii::$app->getRequest()->post();
            $beginDateHour = isset($post['beginDateHour']) ? $post['beginDateHour'] : null;
            $lengthValue = isset($post['lengthValue']) ? $post['lengthValue'] : null;
            $lengthMUId = isset($post['lengthMUId']) ? $post['lengthMUId'] : null;
            if ($beginDateHour && $lengthValue && $lengthMUId) {
                $dbDateTimeFormat = 'Y-m-d H:i:s';
                $dateTime = \DateTime::createFromFormat($dbDateTimeFormat, $beginDateHour);
                $eventLengthMU = EventLengthMeasurementUnit::findOne($lengthMUId);
                if (!is_null($dateTime) && !is_null($eventLengthMU) && is_numeric($lengthValue)) {
                    $interval = 'P';
                    $timePeriod = ['H', 'M', 'S'];
                    if (in_array($eventLengthMU->date_interval_period, $timePeriod)) {
                        $interval .= 'T';
                    }
                    $interval .= $lengthValue . $eventLengthMU->date_interval_period;
                    $dateTime->add(new \DateInterval($interval));
                    $retValDateTime = $dateTime->format($dbDateTimeFormat);
                    $retval['datetime'] = $retValDateTime;
                    $retval['date'] = Yii::$app->getFormatter()->asDate($retValDateTime);
                    $retval['time'] = Yii::$app->getFormatter()->asTime($retValDateTime);
                }
            }
        }
        return json_encode($retval);
    }

    /**
     * @return bool|string
     */
    public function actionGetEventById() {
        /**
         * post('id') is in the form 'cal-event-$id'
         */
        $elements = explode('-', Yii::$app->request->post('id'));
        $id = $elements[count($elements) - 1];
        if (!is_null($id)) {
            /** @var Event $event */
            $event = $this->findModel($id);
            return $this->renderAjax('calendar_event_details', ['model' => $event]);
        }
        return FALSE;
    }

    /**
     * @return string
     */
    public function actionToPublish() {
        $this->setDataProvider($this->modelSearch->searchToPublish(Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(AmosEvents::t('amosevents', 'To publish'), true, 'toPublish');
    }

    /**
     * @return string
     */
    public function actionManagement() {
        $this->setDataProvider($this->modelSearch->searchManagement(Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(AmosEvents::t('amosevents', 'Events management'), true, 'management');
    }

    /**
     * Lists own interests Event models.
     * @return string
     */
    public function actionOwnInterest() {
        $moduleNotify = \Yii::$app->getModule('notify');
        if ($moduleNotify) {
            /** @var \lispa\amos\notificationmanager\AmosNotify $moduleNotify */
            $this->modelSearch->setNotifier($moduleNotify);
        }
        $this->setDataProvider($this->modelSearch->searchCalendarView(Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(AmosEvents::t('amosevents', 'Own Interest Events'));
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSubscribe() {
        $eventId = Yii::$app->request->get('eventId');
        $event = Event::findOne($eventId);

        /** @var User $user */
        $user = User::findOne(Yii::$app->getUser()->id);
        $userId = $user->id;
        $communityId = $event->community_id;

        $defaultAction = ['view', 'id' => $eventId];

        if (!$communityId) {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::tHtml('amosevents', "It is not possible to subscribe the user. Missing parameter community."));
            return $this->redirect($defaultAction);
        }

        /////////////////////////////////////////////////////
        // User joins Community
        $communityUserMm = new CommunityUserMm();
        $communityUserMm->community_id = $communityId;
        $communityUserMm->user_id = $userId;
        $communityUserMm->status = CommunityUserMm::STATUS_WAITING_OK_COMMUNITY_MANAGER;
        $communityUserMm->role = Event::EVENT_PARTICIPANT;
        if ($communityUserMm->save()) {
            Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Your request has been forwarded to event manager for approval.'));
        } else {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'An error occurred. Your request has NOT been forwarded to event manager for approval'));
        }

        /////////////////////////////////////////////////////
        // Send email to event manager
        // Default email values
        $from = $user->email;
        $to = $communityUserMm->getCommunityManagerMailList($event->community_id);
        /** @var UserProfile $userProfile */
        $userProfile = $user->getProfile();
        // Populate SUBJECT
        $subject = AmosEvents::t('amosevents', 'User') . ' ' . $userProfile->getNomeCognome() . ' ' . AmosEvents::t('amosevents', 'asked to join the event') . ' ' . $event->title;

        // Populate TEXT
        $text = $subject;
        $text .= AmosEvents::t('amosevents', 'Type') . ': ' . $event->eventType->title . '<br>';
        $text .= AmosEvents::t('amosevents', 'Title') . ': ' . $event->title . '<br>';
        $text .= AmosEvents::t('amosevents', 'Summary') . ': ' . $event->summary . '<br>';
        $text .= AmosEvents::t('amosevents', 'Published by') . ': ' . UserProfile::findOne(['user_id' => $event->created_by])->getNomeCognome();
        $createUrlParams = [
            '/events/event/view',
            'id' => $eventId
        ];
        $url = Yii::$app->urlManager->createAbsoluteUrl($createUrlParams) . '#tab-participants';
        $text .= Html::a(AmosEvents::t('amosevents', "Sign into the event to accept or reject the request."), $url);

        $files = [];
        $bcc[] = $user->email;
        $params = null;
        $priority = 0;
        $use_queue = true;

        // SEND EMAIL
        utilities\Email::sendMail(
                $from, $to, $subject, $text, $files, $bcc, $params, $priority, $use_queue
        );

        return $this->redirect($defaultAction);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAccept() {
        $eventId = Yii::$app->request->get('eventId');
        $event = Event::findOne($eventId);
        /** @var User $user */
        $user = User::findOne(Yii::$app->getUser()->id);
        $userId = $user->id;
        $communityId = $event->community_id;

        $defaultAction = ['view', 'id' => $eventId];

        if (!$communityId) {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::tHtml('amosevents', "It is not possible to subscribe the user. Missing parameter community."));
            return $this->redirect($defaultAction);
        }

        /////////////////////////////////////////////////////
        // User joins Community
        $communityUserMm = new CommunityUserMm();
        $communityUserMm->community_id = $communityId;
        $communityUserMm->user_id = $userId;
        $communityUserMm->status = CommunityUserMm::STATUS_ACTIVE;
        $communityUserMm->role = Event::EVENT_PARTICIPANT;
        if ($communityUserMm->save()) {
            Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Thank you to join the event.'));
        } else {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'An error occurred. You DID NOT join this event.'));
        }

        /////////////////////////////////////////////////////
        // Send email to event manager
        // Default email values
        $from = $user->email;
        $to = $communityUserMm->getCommunityManagerMailList($event->community_id);
        /** @var UserProfile $userProfile */
        $userProfile = $user->getProfile();
        // Populate SUBJECT
        $subject = AmosEvents::t('amosevents', 'User') . ' ' . $userProfile->getNomeCognome() . ' ' . AmosEvents::t('amosevents', 'accepted to join the event') . ' ' . $event->title;

        // Populate TEXT
        $text = $subject;
        $text .= AmosEvents::t('amosevents', 'Type') . ': ' . $event->eventType->title . '<br>';
        $text .= AmosEvents::t('amosevents', 'Title') . ': ' . $event->title . '<br>';
        $text .= AmosEvents::t('amosevents', 'Summary') . ': ' . $event->summary . '<br>';
        $text .= AmosEvents::t('amosevents', 'Published by') . ': ' . UserProfile::findOne(['user_id' => $event->created_by])->getNomeCognome();
        $createUrlParams = [
            '/events/event/view',
            'id' => $eventId
        ];
        $url = Yii::$app->urlManager->createAbsoluteUrl($createUrlParams) . '#tab-participants';
        $text .= Html::a(AmosEvents::t('amosevents', "Sign into the event."), $url);

        $files = [];
        $bcc[] = $user->email;
        $params = null;
        $priority = 0;
        $use_queue = true;

        // SEND EMAIL
        utilities\Email::sendMail(
                $from, $to, $subject, $text, $files, $bcc, $params, $priority, $use_queue
        );

        return $this->redirect($defaultAction);
    }

    /**
     * Action useful to validate a single event directly. It makes a check on the presence of at least
     * once confirmed manager when there's a community related to the event.
     * @param int $id The event id.
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionValidate($id) {
        /** @var Event $event */
        $event = $this->findModel($id);

        $ok = EventsUtility::checkOneConfirmedManagerPresence($event);
        if (!$ok) {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'The event can not be published. There must be at least one confirmed manager.'));
            return $this->redirect(Url::previous());
        }

        $event->status = Event::EVENTS_WORKFLOW_STATUS_PUBLISHED;
        $event->validated_at_least_once = Event::BOOLEAN_FIELDS_VALUE_YES;
        $event->visible_in_the_calendar = Event::BOOLEAN_FIELDS_VALUE_YES;
        $ok = $event->save(false);
        if ($ok) {
            Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Event successfully published.'));
        } else {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Error while publishing event.'));
        }

        return $this->redirect(Url::previous());
    }

    /**
     * Action to reject the event by an event validator.
     * @param int $id
     * @param bool $visibleInCalendar
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionReject($id, $visibleInCalendar) {
        /** @var Event $event */
        $event = $this->findModel($id);
        $event->status = Event::EVENTS_WORKFLOW_STATUS_DRAFT;
        $event->visible_in_the_calendar = $visibleInCalendar;
        $ok = $event->save(false);
        if ($ok) {
            Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Event successfully rejected.'));
        } else {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Error while rejecting event.'));
        }
        return $this->redirect(Url::previous());
    }

}
