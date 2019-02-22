<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
 */

namespace lispa\amos\events\models\search;

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\interfaces\CmsModelInterface;
use lispa\amos\core\interfaces\SearchModelInterface;
use lispa\amos\core\record\CmsField;
use lispa\amos\core\record\SearchResult;
use lispa\amos\cwh\AmosCwh;
use lispa\amos\cwh\query\CwhActiveQuery;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\Event;
use lispa\amos\events\models\EventMembershipType;
use lispa\amos\notificationmanager\AmosNotify;
use lispa\amos\notificationmanager\base\NotifyWidget;
use lispa\amos\notificationmanager\base\NotifyWidgetDoNothing;
use lispa\amos\notificationmanager\models\NotificationChannels;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\di\Container;
use yii\di\NotInstantiableException;
use yii\helpers\ArrayHelper;


/**
 * Class EventSearch
 * EventSearch represents the model behind the search form about `lispa\amos\events\models\Event`.
 * @package lispa\amos\events\models\search
 */
class EventSearch extends Event implements SearchModelInterface, CmsModelInterface
{
    /**
     * @var Container $container
     */
    private $container;

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        $this->container = new Container();
        $this->container->set('notify', new NotifyWidgetDoNothing());
        parent::__construct($config);
    }

    /**
     * @return object
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function getNotifier()
    {
        return $this->container->get('notify');
    }

    /**
     * @param $notifier
     */
    public function setNotifier(NotifyWidget $notifier)
    {
        $this->container->set('notify', $notifier);
    }

    /**
     * @param ActiveQuery $query
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    private function notificationOff($query)
    {
        $notify = $this->getNotifier();
        if ($notify) {
            /** @var AmosNotify $notify */
            $notify->notificationOff(\Yii::$app->getUser()->id, Event::className(), $query, NotificationChannels::CHANNEL_READ);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [
                [
                    'title',
                    'description',
                    'begin_date_hour',
                    'end_date_hour',
                    'event_type_id',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ],
                'safe'
            ],
            [
                [
                    'begin_date_hour_from',
                    'begin_date_hour_to',
                    'end_date_hour_from',
                    'end_date_hour_to',
                ],
                'safe'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     */
    public function behaviors()
    {
        $parentBehaviors = parent::behaviors();

        $behaviors = [];
        //if the parent model News is a model enabled for tags, NewsSearch will have TaggableBehavior too
        $moduleTag = \Yii::$app->getModule('tag');
        if (isset($moduleTag) && in_array(Event::className(), $moduleTag->modelsEnabled) && $moduleTag->behaviors) {
            $behaviors = ArrayHelper::merge($moduleTag->behaviors, $behaviors);
        }

        return ArrayHelper::merge($parentBehaviors, $behaviors);
    }

    /**
     * @param $params
     * @return ActiveQuery $query
     */
    public function baseSearch($params)
    {
        $module = AmosEvents::instance();
        /** @var Event $eventModel */
        $eventModel = $module->model('Event');
        return $eventModel::find()->distinct();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params, $queryType, $limit = null, $management = false)
    {
        $query = $this->buildQuery($queryType, $params, $management);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => $limit,
            ]
        ]);

        $this->notificationOff($query);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if (isset($params[$this->formName()]['tagValues'])) {

            $tagValues = $params[$this->formName()]['tagValues'];
            $this->setTagValues($tagValues);
            if (is_array($tagValues) && !empty($tagValues)) {
                $andWhere = "";
                $i = 0;
                foreach ($tagValues as $rootId => $tagId) {
                    if (!empty($tagId)) {
                        if ($i == 0) {
                            $query->innerJoin('entitys_tags_mm entities_tag',
                                "entities_tag.classname = '" . addslashes(Event::className()) . "' AND entities_tag.record_id=event.id");

                        } else {
                            $andWhere .= " OR ";
                        }
                        $andWhere .= "(entities_tag.tag_id in (" . $tagId . ") AND entities_tag.root_id = " . $rootId . " AND entities_tag.deleted_at is null)";
                        $i++;
                    }
                }
                $andWhere .= "";
                if (!empty($andWhere)) {
                    $query->andWhere($andWhere);
                }
            }
        }

        $query->joinWith('eventType');

        $query->andFilterWhere([
            'id' => $this->id,
            'event_type_id' => $this->event_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', self::tableName() . '.description', $this->description]);
        $query->andFilterWhere(['>=', self::tableName() . '.begin_date_hour', $this->begin_date_hour]);
        $query->andFilterWhere(['<=', self::tableName() . '.end_date_hour', $this->end_date_hour]);

        return $dataProvider;
    }

    /**
     * Search for events created by the logged user
     *
     * @param array $params $_GET search parametrs
     * @param int|null $limit Query limit
     * @return ActiveDataProvider
     */
    public function searchCreatedBy($params, $limit = null)
    {
        return $this->search($params, 'created-by', $limit);
    }

    /**
     * @param ActiveQuery $query
     */
    private function filterByMembershipType($query)
    {
        $loggedUserId = Yii::$app->getUser()->id;
        $query->leftJoin('community_user_mm', 'community_user_mm.community_id = event.community_id AND community_user_mm.user_id=' . $loggedUserId);
        $query->andWhere('event.event_membership_type_id !=' . EventMembershipType::TYPE_ON_INVITATION . ' OR 
        ( event.event_membership_type_id = ' . EventMembershipType::TYPE_ON_INVITATION . ' AND community_user_mm.user_id = ' . $loggedUserId . ' AND community_user_mm.deleted_at is null )
         OR  ( event.event_management = 0 AND event.event_membership_type_id is null )');
    }

    /**
     * Search for events visible by the logged user and published on the calendar
     *
     * @param array $params $_GET search parametrs
     * @param int|null $limit Query limit
     * @return ActiveDataProvider
     */
    public function searchCalendarView($params, $limit = null)
    {
        return $this->search($params, 'own-interest', $limit);
    }

    /**
     * Search for events that by the logged user has permission to validate
     *
     * @param array $params $_GET search parametrs
     * @param int|null $limit Query limit
     * @return ActiveDataProvider
     */
    public function searchToPublish($params, $limit = null)
    {
        return $this->search($params, 'to-validate', $limit);
    }

    /**
     * Search for events where the the logged user is part of the staff
     *
     * @param array $params $_GET search parametrs
     * @param int|null $limit Query limit
     * @return ActiveDataProvider
     */
    public function searchManagement($params, $limit = null)
    {
        return $this->search($params, 'all', $limit);
    }

    /**
     * @param string $queryType
     * @param array $params
     * @return ActiveQuery $query
     */
    public function buildQuery($queryType, $params, $management = false)
    {
        $query = $this->baseSearch($params);
        $classname = Event::className();
        /** @var  AmosCwh $moduleCwh */
        $moduleCwh = \Yii::$app->getModule('cwh');
        $cwhActiveQuery = null;

        $isSetCwh = isset($moduleCwh) && in_array($classname, $moduleCwh->modelsEnabled);
        if ($isSetCwh) {
            $moduleCwh->setCwhScopeFromSession();
            $cwhActiveQuery = new CwhActiveQuery(
                $classname, [
                'queryBase' => $query
            ]);
        }
        switch ($queryType) {
            case 'created-by':
                if ($isSetCwh) {
                    $query = $cwhActiveQuery->getQueryCwhOwn();
                } else {
                    $query->andFilterWhere([
                        self::tableName() . '.created_by' => Yii::$app->getUser()->id
                    ]);
                }
                break;
            case 'all':
                if ($isSetCwh) {
                    $query = $cwhActiveQuery->getQueryCwhAll();
                } else {
                    $query->andWhere([
                        self::tableName() . '.status' => Event::EVENTS_WORKFLOW_STATUS_PUBLISHED,
                    ]);
                }
                break;
            case'to-validate':
                if ($isSetCwh) {
                    $query = $cwhActiveQuery->getQueryCwhToValidate();
                    $this->filterByMembershipType($query);
                }
                $query->andWhere([
                    self::tableName() . '.status' => Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST,
                ]);
                break;
            case 'own-interest':
                if ($isSetCwh) {
                    $query = $cwhActiveQuery->getQueryCwhOwnInterest();
                    $this->filterByMembershipType($query);
                    $query->andFilterWhere([
                        'validated_at_least_once' => true,
                        'publish_in_the_calendar' => true,
                        'visible_in_the_calendar' => true
                    ]);
                } else {
                    $query->andWhere([
                        self::tableName() . '.status' => Event::EVENTS_WORKFLOW_STATUS_PUBLISHED,
                    ]);
                }
                break;
        }
        if ($management) {
            $query->joinWith('communityUserMm');

            // MANAGEMENT
            $query->andWhere([
                'community_user_mm.user_id' => \Yii::$app->getUser()->id,
                'community_user_mm.status' => CommunityUserMm::STATUS_ACTIVE,
                'community_user_mm.role' => self::EVENT_MANAGER
            ]);
            $query->andFilterWhere([
                'validated_at_least_once' => true,
                'event_management' => true,
            ]);
        }

        return $query;
    }


    /**
     * Search method useful to retrieve events in validated status with both flags publish_in_the_calendar and visible_in_the_calendar true
     *
     * @param array $params Array di parametri
     * @return ActiveDataProvider
     */
    public function searchHighlightedAndHomepageEvents($params)
    {
        $query = $this->highlightedAndHomepageEventsQuery($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'publication_date_begin' => SORT_DESC,
                ],
            ],
        ]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveQuery
     */
    public function highlightedAndHomepageEventsQuery($params)
    {
        $tableName = $this->tableName();
        $query = $this->baseSearch($params)
            ->where([])
            ->andWhere([
                $tableName . '.status' => Event::EVENTS_WORKFLOW_STATUS_PUBLISHED,
            ])
            ->andWhere($tableName . '.deleted_at IS NULL')
            ->andWhere($tableName . '.publish_in_the_calendar = 1')
            ->andWhere($tableName . '.visible_in_the_calendar = 1');
        return $query;
    }

    /**
     * Search all validated documents
     *
     * @param array $searchParamsArray Array of search words
     * @param int|null $pageSize
     * @return ActiveDataProvider
     */
    public function globalSearch($searchParamsArray, $pageSize = 5)
    {
        $dataProvider = $this->search([], 'all', null);
        $pagination = $dataProvider->getPagination();
        if (!$pagination) {
            $pagination = new Pagination();
            $dataProvider->setPagination($pagination);
        }
        $pagination->setPageSize($pageSize);

        // Verifico se il modulo supporta i TAG e, in caso, ricerco anche fra quelli
        $moduleTag = \Yii::$app->getModule('tag');
        $enableTagSearch = isset($moduleTag) && in_array(Event::className(), $moduleTag->modelsEnabled);

        if ($enableTagSearch) {
            $dataProvider->query->leftJoin('entitys_tags_mm e_tag', "e_tag.record_id=event.id AND e_tag.deleted_at IS NULL AND e_tag.classname='" . addslashes(Event::className()) . "'");

            if (Yii::$app->db->schema->getTableSchema('tag__translation')) {
                // Esiste la tabella delle traduzioni dei TAG. Uso quella per la ricerca
                $dataProvider->query->leftJoin('tag__translation tt', "e_tag.tag_id=tt.tag_id");
                $tagTranslationSearch = true;
            }

            $dataProvider->query->leftJoin('tag t', "e_tag.tag_id=t.id");
        }


        foreach ($searchParamsArray as $searchString) {
            $orQueries = [
                'or',
                ['like', self::tableName() . '.title', $searchString],
                ['like', self::tableName() . '.summary', $searchString],
                ['like', self::tableName() . '.description', $searchString],
                ['like', self::tableName() . '.event_location', $searchString],
                ['like', self::tableName() . '.event_address', $searchString],
                ['like', self::tableName() . '.event_address_house_number', $searchString],
                ['like', self::tableName() . '.event_address_cap', $searchString],
            ];

            if ($enableTagSearch) {
                if ($tagTranslationSearch) {
                    $orQueries[] = ['like', 'tt.nome', $searchString];
                }
                $orQueries[] = ['like', 't.nome', $searchString];
            }

            $dataProvider->query->andWhere($orQueries);
        }

        $searchModels = [];
        foreach ($dataProvider->models as $m) {
            array_push($searchModels, $this->convertToSearchResult($m));
        }
        $dataProvider->setModels($searchModels);

        return $dataProvider;
    }

    /**
     * @param object $model The model to convert into SearchResult
     * @return SearchResult
     */
    public function convertToSearchResult($model)
    {
        $searchResult = new SearchResult();
        $searchResult->url = $model->getFullViewUrl();
        $searchResult->box_type = "image";
        $searchResult->id = $model->id;
        $searchResult->titolo = $model->title;
        $searchResult->data_pubblicazione = $model->publication_date_begin;
        $searchResult->immagine = $model->getEventLogo();
        $searchResult->abstract = $model->summary;
        return $searchResult;
    }


    /***
     * CmsModelInterface
     */
    /**
     * Search method useful to retrieve news to show in frontend (with cms)
     *
     * @param $params
     * @param int|null $limit
     * @return ActiveDataProvider
     */
    public function cmsSearch($params, $limit = null)
    {
        $params = array_merge($params, Yii::$app->request->get());
        $dataProvider = $this->search($params, $limit, 'all');

        return $dataProvider;
    }

    public function cmsViewFields() {
        $viewFields = [];
        array_push($viewFields, new CmsField("title", "TEXT", 'amosevents', $this->attributeLabels()["title"]));
        array_push($viewFields, new CmsField("summary", "TEXT", 'amosevents', $this->attributeLabels()['summary']));
        array_push($viewFields, new CmsField("eventLogo", "IMAGE", 'amosevents', $this->attributeLabels()['eventLogo']));
        array_push($viewFields, new CmsField("begin_date_hour", "DATE", 'amosevents', $this->attributeLabels()['begin_date_hour']));
        array_push($viewFields, new CmsField("end_date_hour", "DATE", 'amosevents', $this->attributeLabels()['end_date_hour']));


        return $viewFields;
    }

    public function cmsSearchFields()
    {
        $searchFields = [];

        array_push($searchFields, new CmsField("title", "TEXT"));
        array_push($searchFields, new CmsField("summary", "TEXT"));
        array_push($searchFields, new CmsField("begin_date_hour", "DATE"));

        return $searchFields;
    }

    /**
     *
     * @param type $id
     * @return boolean
     */
    public function cmsIsVisible($id)
    {
        $retValue = true;
        if (isset($id)) {
            $md = $this->findOne($id);
            if (!is_null($md)) {
                $retValue = $md->visible_in_the_calendar;
            }
        }
        return $retValue;
    }
}
