<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
 */

namespace lispa\amos\events;

use lispa\amos\core\interfaces\CmsModuleInterface;
use lispa\amos\core\interfaces\SearchModuleInterface;
use lispa\amos\core\module\AmosModule;
use lispa\amos\core\module\ModuleInterface;
use lispa\amos\events\models\Event;
use lispa\amos\events\models\search\EventSearch;
use yii\helpers\ArrayHelper;

/**
 * Class AmosEvents
 * @package lispa\amos\events
 */
class AmosEvents extends AmosModule implements ModuleInterface, SearchModuleInterface, CmsModuleInterface
{
    public static $CONFIG_FOLDER = 'config';

    /**
     * @var string|boolean the layout that should be applied for views within this module. This refers to a view name
     * relative to [[layoutPath]]. If this is not set, it means the layout value of the [[module|parent module]]
     * will be taken. If this is false, layout will be disabled within this module.
     */
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'lispa\amos\events\controllers';

    public $newFileMode = 0666;
    public $name = 'Events';

    /**
     * If this attribute is true the validation of the publication date is active
     * @var boolean
     */
    public $validatePublicationDateEnd = true;
    /**
     * @var bool|false $enableGoogleMap
     */
    public $enableGoogleMap = true;
    /**
     * @var bool|false $hidePubblicationDate
     */
    public $enableInvitationManagement = true;
    /**
     * @var bool|false $hidePubblicationDate
     */
    public $hidePubblicationDate = false;

    /**
     * This param enable or disable the export button in lists.
     * @var bool $enableExport
     */
    public $enableExport = true;

    public $eventsRequiredFields = [
        'title',
        'summary',
        'description',
        'begin_date_hour',
        'event_type_id',
        'publish_in_the_calendar',
        'event_management',
        'event_commentable',
    ];

    /**
     * @var bool $eventLengthRequired If true enable the required validator on field "length"
     */
    public $eventLengthRequired = false;

    /**
     * @var bool $eventMURequired If true enable the required validator on length measurement unit
     */
    public $eventMURequired = false;

    /**
     * @inheritdoc
     */
    public $db_fields_translation = [
        [
            'namespace' => 'lispa\amos\events\models\EventTypeContext',
            'attributes' => ['title', 'description'],
            'category' => 'amosevents'
        ],
        [
            'namespace' => 'lispa\amos\events\models\EventLengthMeasurementUnit',
            'attributes' => ['title'],
            'category' => 'amosevents'
        ],
        [
            'namespace' => 'lispa\amos\events\models\EventMembershipType',
            'attributes' => ['title'],
            'category' => 'amosevents'
        ],
    ];

    /**
     * @return string
     */
    public static function getModuleName()
    {
        return 'events';
    }

    public static function getModuleIconName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        \Yii::setAlias('@lispa/amos/' . static::getModuleName() . '/controllers', __DIR__ . '/controllers/');
        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php'));
    }

    /**
     * @inheritdoc
     */
    public function getWidgetGraphics()
    {
        return NULL;
    }

    /**
     * @inheritdoc
     */
    public function getWidgetIcons()
    {
        return [
            \lispa\amos\events\widgets\icons\WidgetIconEvents::className(),
            \lispa\amos\events\widgets\icons\WidgetIconEventTypes::className(),
            \lispa\amos\events\widgets\icons\WidgetIconEventsCreatedBy::className(),
            \lispa\amos\events\widgets\icons\WidgetIconEventsToPublish::className(),
            \lispa\amos\events\widgets\icons\WidgetIconEventsManagement::className(),
        ];
    }

    /**
     * Get default model classes
     */
    protected function getDefaultModels()
    {
        return [
            'Event' => __NAMESPACE__ . '\\' . 'models\Event',
            'EventSearch' => __NAMESPACE__ . '\\' . 'models\search\EventSearch',
        ];
    }

    /**
     * This method return the session key that must be used to add in session
     * the url from the user have started the content creation.
     * @return string
     */
    public static function beginCreateNewSessionKey()
    {
        return 'beginCreateNewUrl_' . self::getModuleName();
    }

    /**
     * @param \Google_Service_Calendar $serviceGoogle
     * @param string $calendarId
     * @param string $message
     * @return string $message
     */
    public function synchronizeEvents($serviceGoogle, $calendarId, $message = '')
    {
        $eventSearch = new EventSearch();
        $all = $eventSearch->buildQuery('all', [])->select('event.id')->column();
        $createdBy = $eventSearch->buildQuery('created-by', [])->select('event.id')->column();
        /** @var Event[] $events */
        $events = $eventSearch->baseSearch([])->andWhere([
            'event.id' => ArrayHelper::merge($all, $createdBy)
        ])->all();
        $eventList = $serviceGoogle->events->listEvents($calendarId);
        $items = $eventList->getItems();
        $insertAll = false;
        if (empty($items)) {
            $insertAll = true;
            $isUpdate = false;
        } else {
            $isUpdate = true;
        }

        $insertCount = 0;
        $updatedCount = 0;
        foreach ($events as $event) {
            if ($event->begin_date_hour) {
                $eventId = $event->getGoogleEventId();
                $eventCalendar = null;
                if (!$insertAll) {
                    try {
                        $eventCalendar = $serviceGoogle->events->get($calendarId, $eventId);
                        $isUpdate = true;
                    } catch (\Google_Service_Exception $ex) {
                        $isUpdate = false;
                    }
                }
                $eventCalendar = $event->getGoogleEvent($eventCalendar);
                try {
                    if ($insertAll || !$isUpdate) {
                        $serviceGoogle->events->insert($calendarId, $eventCalendar);
                        $insertCount++;
                    } else {
                        $serviceGoogle->events->update($calendarId, $eventId, $eventCalendar);
                        $updatedCount++;
                    }
                } catch (\Google_Service_Exception $e) {
                    $message .= '<br/>' . $e->getMessage() . '<br/>';
                }
            }
        }
        if ($insertCount) {
            $message .= '<br/>' . AmosEvents::t('amosevents', 'Events added:') . ' ' . $insertCount;
        }
        if ($updatedCount) {
            $message .= '<br/>' . AmosEvents::t('amosevents', 'Events updated:') . ' ' . $updatedCount;
        }

        return $message;
    }


    /**
     * CmsModuleInterface
     */
    public static function getModelSearchClassName()
    {
        return __NAMESPACE__ . '\models\search\EventSearch';
    }

    /**
     * @return string
     */
    public static function getModelClassName()
    {
        return __NAMESPACE__ . '\models\Event';
    }
}
