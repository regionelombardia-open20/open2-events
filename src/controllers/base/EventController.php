<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\controllers
 * @category   CategoryName
 */

namespace lispa\amos\events\controllers\base;

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\BreadcrumbHelper;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\module\BaseAmosModule;
use lispa\amos\dashboard\controllers\TabDashboardControllerTrait;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\assets\EventsAsset;
use lispa\amos\events\models\Event;
use lispa\amos\events\models\search\EventSearch;
use lispa\amos\events\utility\EventsUtility;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class EventController
 * EventController implements the CRUD actions for Event model.
 *
 * @property \lispa\amos\events\models\Event $model
 * @property \lispa\amos\events\models\search\EventSearch $modelSearch
 *
 * @package lispa\amos\events\controllers\base
 */
class EventController extends CrudController {

    use TabDashboardControllerTrait;

    /**
     * @var string $layout
     */
    public $layout = 'list';

    /**
     * @inheritdoc
     */
    public function init() {
        $this->initDashboardTrait();

        $this->setModelObj(AmosEvents::instance()->createModel('Event'));
        $this->setModelSearch(AmosEvents::instance()->createModel('EventSearch'));

        EventsAsset::register(Yii::$app->view);

        $this->setAvailableViews([
            /* 'list' => [
              'name' => 'list',
              'label' => AmosEvents::t('amosevents', '{iconaLista}'.Html::tag('p','Lista'), [
              'iconaLista' => AmosIcons::show('view-list')
              ]),
              'url' => '?currentView=list'
              ],
              'icon' => [
              'name' => 'icon',
              'label' => AmosEvents::t('amosevents', '{iconaElenco}'.Html::tag('p','Icone'), [
              'iconaElenco' => AmosIcons::show('grid')
              ]),
              'url' => '?currentView=icon'
              ],
              'map' => [
              'name' => 'map',
              'label' => AmosEvents::t('amosevents', '{iconaMappa}'.Html::tag('p','Mappa'), [
              'iconaMappa' => AmosIcons::show('map')
              ]),
              'url' => '?currentView=map'
              ], */
            'calendar' => [
                'name' => 'calendar',
                'intestazione' => '', //codice HTML per l'intestazione che verrà caricato prima del calendario,
                //per esempio si può inserire una funzione $model->getHtmlIntestazione() creata ad hoc
                'label' => AmosEvents::t('amosevents', '{calendarIcon}' . Html::tag('p', AmosEvents::t('amosevents', 'Calendar')), [
                    'calendarIcon' => AmosIcons::show('calendar')
                ]),
                'url' => '?currentView=calendar'
            ],
            'grid' => [
                'name' => 'grid',
                'label' => AmosEvents::t('amosevents', '{tableIcon}' . Html::tag('p', AmosEvents::t('amosevents', 'Table')), [
                    'tableIcon' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
        ]);

        parent::init();
        $this->setUpLayout();
    }

    /**
     * Return an array with the values used in boolean fields.
     * @return array
     */
    public function getBooleanFieldsValues() {
        return [
            Event::BOOLEAN_FIELDS_VALUE_NO => AmosEvents::t('amosevents', 'No'),
            Event::BOOLEAN_FIELDS_VALUE_YES => AmosEvents::t('amosevents', 'Yes')
        ];
    }

    /**
     * Manager status for community create in update action.
     * @param Event $model
     * @param array $oldAttributes
     * @return string
     */
    private function getManagerStatus($model, $oldAttributes) {
        $managerStatus = CommunityUserMm::STATUS_MANAGER_TO_CONFIRM;
        if (($this->model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST) && (in_array($this->model->regola_pubblicazione, [3, 4]))) {
            $managerStatus = CommunityUserMm::STATUS_ACTIVE;
        } else if (($model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHED) && (($oldAttributes['validated_at_least_once'] == 1) && ($model->validated_at_least_once == 1))) {
            $managerStatus = CommunityUserMm::STATUS_ACTIVE;
        }
        return $managerStatus;
    }

    /**
     * Set a view param used in \lispa\amos\core\forms\CreateNewButtonWidget
     */
    protected function setCreateNewBtnParams() {
        Yii::$app->view->params['createNewBtnParams'] = [
            'createNewBtnLabel' => AmosEvents::t('amosevents', 'Add new event'),
            'urlCreateNew' => [(array_key_exists("noWizardNewLayout", Yii::$app->params) ? '/events/event/create' : '/event/event-wizard/introduction')],
        ];
    }

    /**
     * This method is useful to set all common params for all list views.
     * @param bool $setCurrentDashboard
     */
    protected function setListViewsParams($setCurrentDashboard = true) {
        $this->setCreateNewBtnParams();
        $this->setUpLayout('list');
        if ($setCurrentDashboard) {
            $this->view->params['currentDashboard'] = $this->getCurrentDashboard();
        }
        Yii::$app->session->set(AmosEvents::beginCreateNewSessionKey(), Url::previous());
        Yii::$app->session->set(AmosEvents::beginCreateNewSessionKeyDateTime(), date('Y-m-d H:i:s'));
    }

    /**
     * Used for set page title and breadcrumbs.
     * @param string $pageTitle News page title (ie. Created by news, ...)
     */
    public function setTitleAndBreadcrumbs($pageTitle) {
        Yii::$app->session->set('previousTitle', $pageTitle);
        Yii::$app->session->set('previousUrl', Url::previous());
        Yii::$app->view->title = $pageTitle;
        Yii::$app->view->params['breadcrumbs'] = [
            ['label' => $pageTitle]
        ];
    }

    /**
     * Base operations for list views
     * @param string $pageTitle
     * @param bool $setCurrentDashboard
     * @return string
     */
    protected function baseListsAction($pageTitle, $setCurrentDashboard = true, $addActionColumns = '') {
        Url::remember();
        $this->setTitleAndBreadcrumbs($pageTitle);
        $this->setListViewsParams($setCurrentDashboard);
        $renderParams = [
            'dataProvider' => $this->getDataProvider(),
            'model' => $this->getModelSearch(),
            'currentView' => $this->getCurrentView(),
            'availableViews' => $this->getAvailableViews(),
            'url' => ($this->url) ? $this->url : null,
            'parametro' => ($this->parametro) ? $this->parametro : null
        ];
        if (strlen($addActionColumns) > 0) {
            $renderParams['addActionColumns'] = $addActionColumns;
        }
        return $this->render('index', $renderParams);
    }

    /**
     * Lists all Event models.
     * @param string|null $layout
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($layout = NULL) {
        return $this->redirect(['/events/event/own-interest']);

        Url::remember();
        $this->setDataProvider($this->getModelSearch()->searchCalendarView(Yii::$app->request->getQueryParams()));
        $this->setListViewsParams();
        $this->setTitleAndBreadcrumbs(AmosEvents::t('amosevents', 'Events'));
        $this->view->params['currentDashboard'] = $this->getCurrentDashboard();
        return parent::actionIndex();
    }

    /**
     * Get latitude and longitude of a place.
     * @deprecated
     * @param string $position
     * @return array
     */
    public function getMapPosition($position) {
        if (!$position) {
            $position = 'Roma';
        }

        /**
         * TODO INSERT KEY GOOGLE ON PARAMS PROJECT
         */
        if (!is_null(Yii::$app->params['googleMapsApiKey'])) {
            $googleMapsKey = Yii::$app->params['googleMapsApiKey'];
        } elseif (Yii::$app->params['google_places_api_key']) {
            $googleMapsKey = Yii::$app->params['google_places_api_key'];
        } elseif (!is_null(Yii::$app->params['google-maps']) && !is_null(Yii::$app->params['google-maps']['key'])) {
            $googleMapsKey = Yii::$app->params['google-maps']['key'];
        } else {
            Yii::$app->session->addFlash('warning', BaseAmosModule::t('amoscore', 'Errore di comunicazione con google: impossibile trovare la posizione nella mappa.'));
            return [];
        }

        $GeoCoderParams = urlencode($position);
        $UrlGeocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=$GeoCoderParams&key=$googleMapsKey";
        $origin = [];
        try {
            $ResulGeocoding = Json::decode(file_get_contents($UrlGeocoder));
        } catch (\Exception $exception) {
            return $origin;
        }

        if ($ResulGeocoding['status'] == 'OK') {
            if (isset($ResulGeocoding['results']) && isset($ResulGeocoding['results'][0])) {
                $Indirizzo = $ResulGeocoding['results'][0];

                if (isset($Indirizzo['geometry'])) {
                    $Location = $Indirizzo['geometry']['location'];

                    if (isset($Location['lat'])) {
                        $origin['latitudine'] = $Location['lat'];
                    }
                    if (isset($Location['lng'])) {
                        $origin['longitudine'] = $Location['lng'];
                    }
                }
            }
        }

        return $origin;
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        Url::remember();
        $this->setUpLayout('main');
        /** @var Event $model */
        $model = $this->findModel($id);

        $latLngOriginStr = ($model->event_address_house_number ? $model->event_address_house_number . ' ' : '');
        $latLngOriginStr .= ($model->event_address ? $model->event_address . ', ' : '');
        $latLngOriginStr .= (!is_null($model->cityLocation) ? $model->cityLocation->nome . ', ' : '');
        $latLngOriginStr .= (!is_null($model->countryLocation) ? $model->countryLocation->nome : '');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                        'model' => $model,
                        'position' => $latLngOriginStr
            ]);
        }
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $this->setUpLayout('form');

        /** @var AmosEvents $module */
        $module = \Yii::$app->getModule(AmosEvents::getModuleName());
        if ($module->hidePubblicationDate == true) {
            /** @var Event $model */
            $model = $module->createModel('Event', ['scenario' => Event::SCENARIO_CREATE_HIDE_PUBBLICATION_DATE]);
            $model->setScenario(Event::SCENARIO_CREATE_HIDE_PUBBLICATION_DATE);
        } else {
            /** @var Event $model */
            $model = $module->createModel('Event', ['scenario' => Event::SCENARIO_CREATE]);
            $model->setScenario(Event::SCENARIO_CREATE);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->model = $model;
            $validateOnSave = true;
            if ($this->model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST) {
                $this->model->status = Event::EVENTS_WORKFLOW_STATUS_DRAFT;
                $this->model->save();
                $this->model->status = Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST;
                $validateOnSave = false;
            }
            if ($this->model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHED) {
                $this->model->status = Event::EVENTS_WORKFLOW_STATUS_DRAFT;
                $this->model->save();
                $this->model->status = Event::EVENTS_WORKFLOW_STATUS_PUBLISHED;
                $validateOnSave = false;
            }
            if ($model->save($validateOnSave)) {
                Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Element successfully created.'));
                return $this->redirect(['/events/event/update', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Element not created, check the data entered.'));
                return $this->render('create', [
                            'model' => $model,
                            'fid' => NULL,
                            'dataField' => NULL,
                            'dataEntity' => NULL,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'fid' => NULL,
                        'dataField' => NULL,
                        'dataEntity' => NULL,
            ]);
        }
    }

    /**
     * Creates a new Event model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField) {
        $this->setUpLayout('form');
//        $model = new Event;
//        $model->setScenario(Event::SCENARIO_CREATE);
        $model = $module->createModel('Event', ['scenario' => Event::SCENARIO_CREATE]);

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                //Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Element successfully created.'));
                return json_encode($model->toArray());
            } else {
                //Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Element not created, check the data entered.'));
                return $this->renderAjax('_formAjax', [
                            'model' => $model,
                            'fid' => $fid,
                            'dataField' => $dataField
                ]);
            }
        } else {
            return $this->renderAjax('_formAjax', [
                        'model' => $model,
                        'fid' => $fid,
                        'dataField' => $dataField
            ]);
        }
    }

    /**
     * Updates an existing Event model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $backToEditStatus = false) {
        Url::remember();
        $this->setUpLayout('form');

        /** @var Event $model */
        $model = $this->findModel($id);
        $this->updateFindModel();

        $oldAttributes = $model->getOldAttributes();

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $validateOnSave = true;
                    if ($model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHED) {
                        $model->status = Event::EVENTS_WORKFLOW_STATUS_DRAFT;
                        $model->save();
                        $model->status = Event::EVENTS_WORKFLOW_STATUS_PUBLISHED;
                        $validateOnSave = false;
                    }
                    if ($model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHED) {
                        $model->validated_at_least_once = Event::BOOLEAN_FIELDS_VALUE_YES;
                        $model->visible_in_the_calendar = Event::BOOLEAN_FIELDS_VALUE_YES;
                    }

                    if ($model->status != Event::EVENTS_WORKFLOW_STATUS_DRAFT) {
                        if ($model->event_management) {
                            if (is_null($model->community_id)) {
                                $managerStatus = $this->getManagerStatus($model, $oldAttributes);
                                $ok = EventsUtility::createCommunity($model, $managerStatus);
                            } else {
                                $ok = EventsUtility::updateCommunity($model);
                            }
                            if ($ok && ($model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHED)) {
                                if (($oldAttributes['validated_at_least_once'] == 0) && ($model->validated_at_least_once == 1)) {
                                    // If it's the first validation, check if the logged user is the same as the manager.
                                    // In that case set the manager in the active status.
                                    $eventManagers = EventsUtility::findEventManagers($model);
                                    foreach ($eventManagers as $eventManager) {
                                        /** @var CommunityUserMm $eventManager */
                                        if (($eventManager->user_id == Yii::$app->getUser()->getId()) && ($eventManager->status != CommunityUserMm::STATUS_ACTIVE)) {
                                            $eventManager->status = CommunityUserMm::STATUS_ACTIVE;
                                            $eventManager->save();
                                        }
                                    }
                                }

                                $ok = EventsUtility::checkOneConfirmedManagerPresence($model);
                                if (!$ok) {
                                    Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'The event can not be published. There must be at least one confirmed manager.'));
                                }
                            }
                        }
                        if (!$model->event_management && !is_null($model->community_id)) {
                            try {
                                $model->community->delete();
                                if ($model->community->getErrors()) {
                                    Yii::$app->getSession()->addFlash('info', AmosEvents::t('amosevents', 'Error while deleting community.'));
                                } else {
                                    EventsUtility::deleteCommunityLogo($model);
                                    $model->community_id = null;
                                }
                            } catch (\Exception $exception) {
                                Yii::$app->getSession()->addFlash('info', AmosEvents::t('amosevents', 'Community cannot be deleted.'));
                            }
                        }
                    }
                    if ($model->save($validateOnSave)) {
                        if ($model->event_management && !is_null($model->community_id)) {
                            $ok = EventsUtility::duplicateEventLogoForCommunity($model);
                            if ($ok) {
                                Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Element successfully updated.'));
                            } else {
                                Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'There was an error while saving.'));
                            }
                        } else {
                            Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Element successfully updated.'));
                        }
                        if ($model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST && !\Yii::$app->user->can('EventValidate', ['model' => $model])) {
                            return $this->redirect(BreadcrumbHelper::lastCrumbUrl());
                        }
                        return $this->redirect(['/events/event/update', 'id' => $model->id]);
                    } else {
                        Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'There was an error while saving.'));
                        return $this->render('create', [
                                    'model' => $model,
                                    'fid' => NULL,
                                    'dataField' => NULL,
                                    'dataEntity' => NULL,
                        ]);
                    }
                } else {
                    Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Element not updated, check the data entered.'));
                }
            }
        } else {
            if ($backToEditStatus && ($model->status != $model->getDraftStatus() && !Yii::$app->user->can('EventValidate', ['model' => $model]))) {
                $model->status = $model->getDraftStatus();
                $ok = $model->save(false);
                if (!$ok) {
                    Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'There was an error while saving.'));
                }
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'fid' => NULL,
                    'dataField' => NULL,
                    'dataEntity' => NULL,
        ]);
    }

    /**
     * Method called after findModel in action update.
     */
    protected function updateFindModel() {
        
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        /** @var Event $model */
        $model = $this->findModel($id);
        if ($model) {
            $ok = true;
            //si può sostituire il  delete() con forceDelete() in caso di SOFT DELETE attiva
            //In caso di soft delete attiva e usando la funzione delete() non sarà bloccata
            //la cancellazione del record in presenza di foreign key quindi
            //il record sarà cancelleto comunque anche in presenza di tabelle collegate a questo record
            //e non saranno cancellate le dipendenze e non avremo nemmeno evidenza della loro presenza
            //In caso di soft delete attiva è consigliato modificare la funzione oppure utilizzare il forceDelete() che non andrà
            //mai a buon fine in caso di dipendenze presenti sul record da cancellare
            if (!is_null($model->community) && is_null($model->community->deleted_at)) {
                try {
                    $model->community->delete();
                } catch (\Exception $exception) {
                    $ok = false;
                    Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Errors while deleting event community.'));
                }
                if ($model->community->getErrors()) {
                    $ok = false;
                    Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Errors while deleting event community.'));
                }
            }

            if ($ok) {
                $model->delete();
                if (!$model->getErrors()) {
                    Yii::$app->getSession()->addFlash('success', AmosEvents::t('amosevents', 'Element succesfully deleted.'));
                } else {
                    Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Errors while deleting element.'));
                }
            }
        } else {
            Yii::$app->getSession()->addFlash('danger', AmosEvents::t('amosevents', 'Element not found.'));
        }
        return $this->redirect(Yii::$app->session->get(AmosEvents::beginCreateNewSessionKey()));
    }

}
