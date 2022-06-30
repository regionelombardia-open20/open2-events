<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\events\models\base
 * @category   CategoryName
 */

namespace open20\amos\events\models\base;

use open20\amos\attachments\behaviors\FileBehavior;
use open20\amos\community\models\CommunityInterface;
use open20\amos\events\AmosEvents;
use open20\amos\events\validators\CapValidator;
use open20\amos\core\record\ContentModel;
use open20\amos\workflow\behaviors\WorkflowLogFunctionsBehavior;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use yii\helpers\ArrayHelper;
use Yii;
/**
 * Class Event
 * This is the base-model class for table "event".
 *
 * @property integer $id
 * @property string $status
 * @property string $title
 * @property string $summary
 * @property string $description
 * @property string $begin_date_hour
 * @property integer $length
 * @property string $end_date_hour
 * @property string $publication_date_begin
 * @property string $publication_date_end
 * @property string $registration_date_begin
 * @property string $registration_date_end
 * @property string $show_community
 * @property string $show_on_frontend
 * @property integer $has_tickets
 * @property integer $slots_calendar_management
 * @property integer $seats_management
 * @property integer $has_qr_code
 * @property integer $abilita_codice_fiscale_in_form
 * @property integer $numero_max_accompagnatori
 * @property string $landing_url
 * @property string $frontend_page_title
 * @property string $frontend_claim
 * @property string $registration_limit_date
 * @property string $event_location
 * @property string $event_address
 * @property string $event_address_house_number
 * @property string $event_address_cap
 * @property integer $seats_available
 * @property integer $paid_event
 * @property integer $publish_in_the_calendar
 * @property integer $visible_in_the_calendar
 * @property integer $event_commentable
 * @property integer $event_management
 * @property integer $validated_at_least_once
 * @property integer $city_location_id
 * @property integer $province_location_id
 * @property integer $country_location_id
 * @property integer $event_membership_type_id
 * @property integer $length_mu_id
 * @property integer $ics_libero
 * @property integer $event_type_id
 * @property integer $community_id
 * @property string $gdpr_question_1
 * @property string $gdpr_question_2
 * @property string $gdpr_question_3
 * @property string $gdpr_question_4
 * @property string $gdpr_question_5
 * @property string $thank_you_page_view
 * @property integer $use_token
 * @property string $token_group_string_code
 * @property string $thank_you_page_already_registered_view
 * @property string $subscribe_form_page_view
 * @property string $email_view
 * @property string $event_closed_page_view
 * @property string $event_full_page_view
 * @property string $ticket_layout_view
 * @property integer $sent_credential
 * @property string $email_subscribe_view
 * @property string $email_invitation_custom
 * @property integer $email_credential_subject
 * @property string $email_credential_view
 * @property string $email_ticket_layout_custom
 * @property string $email_ticket_sender
 * @property string $email_ticket_subject
 * @property integer $event_room_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property integer $primo_piano
 * @property integer $in_evidenza
 *
 * @property \open20\amos\events\models\EventType $eventType
 * @property \open20\amos\admin\models\UserProfile $users
 * @property \open20\amos\comuni\models\IstatComuni $cityLocation
 * @property \open20\amos\comuni\models\IstatProvince $provinceLocation
 * @property \open20\amos\comuni\models\IstatNazioni $countryLocation
 * @property \open20\amos\events\models\EventMembershipType $eventMembershipType
 * @property \open20\amos\events\models\EventLengthMeasurementUnit $eventLengthMeasurementUnit
 * @property \open20\amos\community\models\CommunityUserMm $communityUserMm
 * @property \open20\amos\community\models\Community $community
 * @property \open20\amos\events\models\EventRoom $eventRoom
 *
 * @package open20\amos\events\models\base
 */
abstract class Event extends ContentModel implements CommunityInterface
{
    const EVENTS_WORKFLOW = 'EventWorkflow';
    const EVENTS_WORKFLOW_STATUS_DRAFT = 'EventWorkflow/DRAFT';
    const EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST = 'EventWorkflow/PUBLISHREQUEST';
    const EVENTS_WORKFLOW_STATUS_PUBLISHED = 'EventWorkflow/PUBLISHED';

    const BOOLEAN_FIELDS_VALUE_YES = 1;
    const BOOLEAN_FIELDS_VALUE_NO = 0;

    /**
     * Used for create events in the traditional form (action create).
     */
    const SCENARIO_CREATE = 'scenario_create';

    /**
     * All the scenarios listed below are for the wizard.
     */
    const SCENARIO_INTRODUCTION = 'scenario_introduction';
    const SCENARIO_DESCRIPTION = 'scenario_description';
    const SCENARIO_ORGANIZATIONALDATA = 'scenario_organizationaldata';
    const SCENARIO_PUBLICATION = 'scenario_publication';
    const SCENARIO_SUMMARY = 'scenario_summary';

    const SCENARIO_ORG_HIDE_PUBBLICATION_DATE = 'scenario_org_hide_pubblication_date';
    const SCENARIO_CREATE_HIDE_PUBBLICATION_DATE = 'scenario_create_hide_pubblication_date';

    /**
     * @var AmosEvents $eventsModule
     */
    public $eventsModule = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->eventsModule = AmosEvents::instance();

        parent::init();

        if ($this->isNewRecord) {
            if (!is_null($this->eventsModule)) {
                if ($this->eventsModule->hidePubblicationDate) {
                    // the news will be visible forever
                    $this->publication_date_end = '9999-12-31 23:59:59';
                }
                $this->publication_date_begin = date('Y-m-d H:i:s');
            }
            $this->event_membership_type_id = \open20\amos\events\models\EventMembershipType::TYPE_OPEN;
            $this->status = $this->getWorkflowSource()->getWorkflow(self::EVENTS_WORKFLOW)->getInitialStatusId();
            
            if ($this->status == self::EVENTS_WORKFLOW_STATUS_PUBLISHED) {
                $this->validated_at_least_once = Event::BOOLEAN_FIELDS_VALUE_YES;
                $this->visible_in_the_calendar = Event::BOOLEAN_FIELDS_VALUE_YES;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $requiredFields = $this->eventsModule->eventsRequiredFields;
        if ($this->eventsModule->eventLengthRequired) {
            $requiredFields = ArrayHelper::merge($requiredFields, ['length']);
        }
        
        if ($this->eventsModule->eventMURequired) {
            $requiredFields = ArrayHelper::merge($requiredFields, ['length_mu_id']);
        }
        
        $rules = ArrayHelper::merge(
            parent::rules(), [
            [$requiredFields, 'required'],
            [[
                'begin_date_hour',
                'end_date_hour',
                'publication_date_begin',
                'publication_date_end',
                'length_mu_id',
                'event_location',
                'event_address',
                'event_address_house_number',
                'event_address_cap',
                'registration_limit_date',
                'event_membership_type_id',
                'city_location_id',
                'province_location_id',
                'country_location_id',
                'status',
                'created_at',
                'updated_at',
                'deleted_at',
                'seats_available',
                'tagValues',
                'numero_max_accompagnatori',
                'gdpr_question_1',
                'gdpr_question_2',
                'gdpr_question_3',
                'gdpr_question_4',
                'gdpr_question_5',
                'thank_you_page_view',
                'subscribe_form_page_view',
                'email_view',
                'event_closed_page_view',
                'event_full_page_view',
                'ticket_layout_view',
                'email_subscribe_view',
                'email_credential_view',
                'registration_date_begin',
                'registration_date_end',
                'seats_management'
            ], 'safe'],
            [[
                'primo_piano',
                'in_evidenza',
                'city_location_id',
                'province_location_id',
                'country_location_id',
                'event_membership_type_id',
                'event_type_id',
                'community_id',
                'abilita_codice_fiscale_in_form',
                'numero_max_accompagnatori',
                'has_tickets',
                'has_qr_code',
                'created_by',
                'updated_by',
                'deleted_by',
                'numero_max_accompagnatori',
                'slots_calendar_management',
                'sent_credential',
                'use_token',
                'event_room_id',
                'ics_libero',
            ], 'integer'],
            [['length'], 'number', 'min' => 1, 'integerOnly' => true],
            [['title', 'event_address'], 'string', 'max' => 100],
            [['summary', 'status', 'event_location', 'email_credential_subject', 'email_invitation_custom', 'thank_you_page_already_registered_view', 'token_group_string_code'], 'string', 'max' => 255],
            [['description', 'email_ticket_layout_custom', 'email_ticket_sender', 'email_ticket_subject'], 'string'],
            [['event_address_cap'], CapValidator::className()],
            [['event_address_cap'], 'string', 'max' => 5],
            [['event_location', 'event_address', 'event_address_cap', 'event_address_house_number', 'country_location_id'], 'required', 'when' => function ($model) {
                /** @var \open20\amos\events\models\Event $model */
                if (is_null($this->eventType)) {
                    return false;
                }
                return ($this->eventType->locationRequested == 1 ? true : false);
            }, 'whenClient' => "function (attribute, value) {
                return " . (!is_null($this->eventType) ? $this->eventType->locationRequested : 0) . ";
            }"],
            [['province_location_id', 'city_location_id'], 'required', 'when' => function ($model) {
                /** @var \open20\amos\events\models\Event $model */
                if (is_null($this->eventType)) {
                    return false;
                }
                return ((($this->eventType->locationRequested == 1) && ($this->country_location_id == 1)) ? true : false);
            }, 'whenClient' => "function (attribute, value) {
                return " . (!is_null($this->eventType) ? ((($this->eventType->locationRequested == 1) && ($this->country_location_id == 1)) ? 1 : 0) : 0) . ";
            }"],
            [['length', 'length_mu_id'], 'required', 'when' => function ($model) {
                /** @var \open20\amos\events\models\Event $model */
                if (is_null($this->eventType)) {
                    return false;
                }
                return ($model->eventType->durationRequested == 1 ? true : false);
            }, 'whenClient' => "function (attribute, value) {
                return " . (!is_null($this->eventType) ? $this->eventType->durationRequested : 0) . ";
            }"],
            [['event_membership_type_id', 'seats_available', 'paid_event'], 'required', 'when' => function ($model) {
                /** @var \open20\amos\events\models\Event $model */
                return ($model->event_management == 1 ? true : false);
            }, 'whenClient' => "function (attribute, value) {
                return ($('#event-event_management').val() == '1');
            }"],
            [['seats_available'], 'required', 'when' => function ($model) {
                /** @var \open20\amos\events\models\Event $model */
                return (!is_null($this->eventType) ? $this->eventType->limited_seats == 1 ? true : false : false);
            }, 'whenClient' => "function (attribute, value) {
                return " . (!is_null($this->eventType) ? $this->eventType->limited_seats == 1 ? 1 : 0 : 0) . ";
            }"],
        ]);

        if ($this->scenario != self::SCENARIO_ORG_HIDE_PUBBLICATION_DATE && $this->scenario != self::SCENARIO_CREATE_HIDE_PUBBLICATION_DATE && $this->scenario
                && (!empty($this->publication_date_begin) && !empty($this->publication_date_end)) ) {
            $rules = ArrayHelper::merge($rules, [
                ['publication_date_begin', 'compare', 'compareAttribute' => 'publication_date_end', 'operator' => '<='],
                ['publication_date_end', 'compare', 'compareAttribute' => 'publication_date_begin', 'operator' => '>='],
                ['publication_date_begin', 'checkDate'],
            ]);
        }
        
        return $rules;
    }

    /**
     * Validation of $attribute if the attribute publication date of the module is true
     * @param string $attribute
     * @param array $params
     */
    public function checkDate($attribute, $params)
    {
        $isValid = true;
        if ($this->isNewRecord && \Yii::$app->getModule('events')->validatePublicationDateEnd == true) {
            if ($this->$attribute < date('Y-m-d H:i:s')) {
                $isValid = false;
            }
        }
        
        if (!$isValid) {
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' ' . AmosEvents::t('amosevents', "may not be less than today's date"));
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'fileBehavior' => [
                    'class' => FileBehavior::className()
                ],
                'workflow' => [
                    'class' => SimpleWorkflowBehavior::className(),
                    'defaultWorkflowId' => self::EVENTS_WORKFLOW,
                    'propagateErrorsToModel' => true
                ],
                'workflowLog' => [
                    'class' => WorkflowLogFunctionsBehavior::className()
                ],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        $scenarios = ArrayHelper::merge(
            parent::scenarios(),
            $this->createActionScenarios()
        );

        /** @var AmosEvents $eventModule */
        $eventModule = Yii::$app->getModule(AmosEvents::getModuleName());
        if ($eventModule->params['site_publish_enabled']) {
            $scenarios[self::SCENARIO_CREATE][] = 'primo_piano';
        }
        
        if ($eventModule->params['site_featured_enabled']) {
            $scenarios[self::SCENARIO_CREATE][] = 'in_evidenza';
        }
        
        $scenarios[self::SCENARIO_CREATE_HIDE_PUBBLICATION_DATE] = $scenarios[self::SCENARIO_CREATE];
        
        return $scenarios;
    }

    /**
     * All create action behaviors.
     * @return array
     */
    private function createActionScenarios()
    {
        return [
            self::SCENARIO_CREATE => [
                'event_type_id',
                'title'
            ],
            self::SCENARIO_CREATE_HIDE_PUBBLICATION_DATE => [
                'event_type_id',
                'title'
            ]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosEvents::t('amosevents', 'ID'),
            'status' => AmosEvents::t('amosevents', 'Status'),
            'title' => AmosEvents::t('amosevents', 'Title'),
            'summary' => AmosEvents::t('amosevents', 'Summary'),
            'description' => AmosEvents::t('amosevents', 'Description'),
            'begin_date_hour' => AmosEvents::t('amosevents', 'Begin Date And Hour'),
            'length' => AmosEvents::t('amosevents', 'Length'),
            'end_date_hour' => AmosEvents::t('amosevents', 'End Date And Hour'),
            'ics_libero' => AmosEvents::t('amosevents', 'ICS scaricabile senza login'),
            'notes' => AmosEvents::t('amosevents', '#participant_note'),
            'publication_date_begin' => AmosEvents::t('amosevents', 'Publication Date Begin'),
            'publication_date_end' => AmosEvents::t('amosevents', 'Publication Date End'),
            'publication_date_begin' => AmosEvents::t('amosevents', 'Data e ora di inizio pubblicazione'),
            'publication_date_end' => AmosEvents::t('amosevents', 'Data e ora di fine pubblicazione'),
            'registration_date_begin' => AmosEvents::t('amosevents', 'Data e ora di apertura iscrizione'),
            'registration_date_end' => AmosEvents::t('amosevents', 'Data e ora chiusura iscrizioni'),
            'show_community' => AmosEvents::t('amosevents', '#show_community_label'),
            'show_on_frontend' => AmosEvents::t('amosevents', '#show_on_frontend_label'),
            'landing_url' => AmosEvents::t('amosevents', '#landing_url_label'),
            'frontend_page_title' => AmosEvents::t('amosevents', '#frontend_page_title_label'),
            'frontend_claim' => AmosEvents::t('amosevents', '#frontend_claim_label'),
            'registration_limit_date' => AmosEvents::t('amosevents', 'Registration Limit Date'),
            'event_location' => AmosEvents::t('amosevents', 'Event Location'),
            'event_address' => AmosEvents::t('amosevents', 'Event Address'),
            'event_address_house_number' => AmosEvents::t('amosevents', 'Event Address House Number'),
            'event_address_cap' => AmosEvents::t('amosevents', 'Event Address Cap'),
            'seats_available' => AmosEvents::t('amosevents', 'Seats Available'),
            'paid_event' => AmosEvents::t('amosevents', 'Paid Event'),
            'publish_in_the_calendar' => AmosEvents::t('amosevents', 'Publish In The Calendar'),
            'visible_in_the_calendar' => AmosEvents::t('amosevents', 'Visible In The Calendar'),
            'event_commentable' => AmosEvents::t('amosevents', 'Event Commentable'),
            'email_credential_view' => AmosEvents::t('amosevents', 'View custom della mail delle credenziali'),
            'event_management' => AmosEvents::t('amosevents', 'Event Management'),
            'validated_at_least_once' => AmosEvents::t('amosevents', 'Validated At Least Once'),
            'seats_management' => AmosEvents::t('amosevents', 'Gestione posti'),
            'sent_credential' => AmosEvents::t('amosevents', 'Invia le credenziali'),
            'country_location_id' => AmosEvents::t('amosevents', 'Country Location'),
            'province_location_id' => AmosEvents::t('amosevents', 'Province Location'),
            'city_location_id' => AmosEvents::t('amosevents', 'City Location'),
            'event_membership_type_id' => AmosEvents::t('amosevents', 'Event Membership Type ID'),
            'email_credential_subject' => AmosEvents::t('amosevents', 'Soggetto della mail delle credenziali'),
            'length_mu_id' => AmosEvents::t('amosevents', 'Length Measurement Unit ID'),
            'event_type_id' => AmosEvents::t('amosevents', 'Event Type'),
            'community_id' => AmosEvents::t('amosevents', 'Community ID'),
            'created_at' => AmosEvents::t('amosevents', 'Created At'),
            'updated_at' => AmosEvents::t('amosevents', 'Updated At'),
            'deleted_at' => AmosEvents::t('amosevents', 'Deleted At'),
            'created_by' => AmosEvents::t('amosevents', 'Created By'),
            'updated_by' => AmosEvents::t('amosevents', 'Updated By'),
            'deleted_by' => AmosEvents::t('amosevents', 'Deleted By'),
            'primo_piano' => AmosEvents::t('amosevents', 'Pubblica sul sito'),
            'in_evidenza' => AmosEvents::t('amosevents', 'In evidenza'),
            'eventType' => AmosEvents::t('amosevents', 'Event Type'),
            'eventLengthMeasurementUnit' => AmosEvents::t('amosevents', 'Length Measurement Unit'),
            'eventMembershipType' => AmosEvents::t('amosevents', 'Event Membership Type'),
            'subscribe_form_page_view' => AmosEvents::t('amosevents', 'Custom view form di iscrizione'),
            'thank_you_page_view' => AmosEvents::t('amosevents', 'Thank you page custom'),
            'use_token' => AmosEvents::t('amosevents', 'Usa token di accesso'),
            'token_group_string_code' => AmosEvents::t('amosevents', 'Codice del gruppo di token'),
            'thank_you_page_already_registered_view' => AmosEvents::t('amosevents', 'Thank you page custom per utenti già registrati'),
            'email_view' => AmosEvents::t('amosevents', 'email_view'),
            'email_ticket_layout_custom' => AmosEvents::t('amosevents', 'Layout della mail del ticket'),
            'email_invitation_custom' => AmosEvents::t('amosevents', 'View custom della mail di invito'),
            'email_ticket_sender' => AmosEvents::t('amosevents', 'Sender della mail del ticket'),
            'email_ticket_subject' => AmosEvents::t('amosevents', 'Soggetto della mail del ticket'),
            'event_closed_page_view' => AmosEvents::t('amosevents', 'event_closed_page_view'),
            'event_full_page_view' => AmosEvents::t('amosevents', 'event_full_page_view'),
            'ticket_layout_view' => AmosEvents::t('amosevents', 'ticket_layout_view'),
            'email_subscribe_view' => AmosEvents::t('amosevents', 'email_subscribe_view'),
            'event_room_id' => AmosEvents::t('amosevents', '#event_room_id'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventType()
    {
        return $this->hasOne($this->eventsModule->model('EventType'), ['id' => 'event_type_id']);
    }

    /**
     * @inheritdoc
     */
    public function getCommunityId()
    {
        return $this->community_id;
    }

    /**
     * @inheritdoc
     */
    public function setCommunityId($communityId)
    {
        $this->community_id = $communityId;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(\open20\amos\community\models\Community::className(), ['id' => 'community_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunityUserMm()
    {
        return $this->hasMany(\open20\amos\community\models\CommunityUserMm::className(), ['community_id' => 'community_id']);
    }

    /**
     * @return string
     */
    public function getAttrEventTypeMm()
    {
        return '' . $this->eventType->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityLocation()
    {
        return $this->hasOne(\open20\amos\comuni\models\IstatComuni::className(), ['id' => 'city_location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinceLocation()
    {
        return $this->hasOne(\open20\amos\comuni\models\IstatProvince::className(), ['id' => 'province_location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryLocation()
    {
        return $this->hasOne(\open20\amos\comuni\models\IstatNazioni::className(), ['id' => 'country_location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventMembershipType()
    {
        return $this->hasOne($this->eventsModule->model('EventMembershipType'), ['id' => 'event_membership_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventLengthMeasurementUnit()
    {
        return $this->hasOne($this->eventsModule->model('EventLengthMeasurementUnit'), ['id' => 'length_mu_id']);
    }

    public function countGdprQuestions()
    {
        $count = 0;
        if ($this->eventsModule->enableGdpr) {
            if(!empty($this->gdpr_question_1)) { $count++; }
            if(!empty($this->gdpr_question_2)) { $count++; }
            if(!empty($this->gdpr_question_3)) { $count++; }
            if(!empty($this->gdpr_question_4)) { $count++; }
            if(!empty($this->gdpr_question_5)) { $count++; }
        }
        return $count;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventSeats()
    {
        return $this->hasMany($this->eventsModule->model('EventSeats'), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventCalendars()
    {
        return $this->hasMany($this->eventsModule->model('EventCalendars'), [ 'event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventRoom()
    {
        return $this->hasOne($this->eventsModule->model('EventRoom'), ['id' => 'event_room_id']);
    }
}
