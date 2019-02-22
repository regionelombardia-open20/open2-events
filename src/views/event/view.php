<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\event
 * @category   CategoryName
 */

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\community\widgets\CommunityMembersWidget;
use lispa\amos\core\forms\CloseButtonWidget;
use lispa\amos\core\forms\ContextMenuWidget;
use lispa\amos\core\forms\MapWidget;
use lispa\amos\core\forms\Tabs;
use lispa\amos\core\helpers\Html;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\Event;
use lispa\amos\events\models\EventMembershipType;

/**
 * @var yii\web\View $this
 * @var lispa\amos\events\models\Event $model
 * @var string $position
 */

$this->title = strip_tags($model->title);
$this->params['breadcrumbs'][] = ['label' => Yii::$app->session->get('previousTitle'), 'url' => Yii::$app->session->get('previousUrl')];
$this->params['breadcrumbs'][] = $this->title;

$communityPresent = ($model->event_management && !is_null($model->community) && is_null($model->community->deleted_at));

?>
<div class="event-view col-xs-12 nop">
    <?php $this->beginBlock('overview'); ?>
    <div class="col-xs-12 nop nom">
        <?= \lispa\amos\core\forms\ItemAndCardHeaderWidget::widget([
            'model' => $model,
            'publicationDateField' => 'created_at',
        ]) ?>


        <div class='col-sm-7 col-xs-12 nop'>
            <div class="nop media">
                <div class="col-xs-12 col-sm-3 nopl">
                    <?php
                    $url = '/img/img_default.jpg';
                    if (!is_null($model->eventLogo)) {
                        $url = $model->eventLogo->getUrl('original', false, true);
                    }
                    ?>
                    <?= Html::img($url, [
                        'title' => $model->getAttributeLabel('eventLogo'),
                        'class' => 'img-responsive img-round'
                    ]); ?>
                </div>

                <div class="media-body">
                    <div class="col-xs-9">
                        <p class="media-heading">
                            <?= AmosEvents::t('amosevents', 'Event'); ?>
                        </p>
                        <h2 class="media-heading">
                            <?= $model->title ?>
                        </h2>
                    </div>
                    <?= ContextMenuWidget::widget([
                        'model' => $model,
                        'actionModify' => "/events/event/update?id=" . $model->id,
                        'actionDelete' => "/events/event/delete?id=" . $model->id,
                        'modelValidatePermission' => 'EventValidate'
                    ]) ?>

                    <div class="col-xs-12 nop m-t-15">
                        <div class="col-sm-4 col-xs-12">
                            <?= $model->getAttributeLabel('eventType') ?>
                            <br/>
                            <span class="bold"><?= $model->eventType->title ?></span>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <?= AmosEvents::t('amosevents', 'Country') ?>
                            <br/>
                            <span class="bold"><?= ($model->countryLocation) ? $model->countryLocation->nome : '-' ?></span>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <?= AmosEvents::t('amosevents', 'City') ?>
                            <br/>
                            <span class="bold"><?= ($model->cityLocation) ? $model->cityLocation->nome : '-' ?>
                                <?= ($model->provinceLocation) ? ' (' . $model->provinceLocation->sigla . ')' : '' ?></span>
                        </div>
                    </div>

                </div>
            </div>
            <hr/>

            <div class="clearfix"></div>

            <p class="italic m-t-15"><?= $model->summary ?></p>
            <p class="m-t-15"><?= $model->description ?></p>

            <div class="box-background col-xs-12 m-t-15">
                <div class="col-sm-2 col-xs-12">
                    <label><?= $model->getAttributeLabel('paid_event'); ?></label>
                    <p class="boxed-data"><?= ($model->paid_event) ? AmosEvents::t('amosevents', 'Yes') : AmosEvents::t('amosevents', 'No') ?></p>
                </div>
<!--                <div class="col-sm-7 col-xs-12">-->
<!--                    <label>< ?= AmosEvents::t('amosevents', 'Project') ?></label>-->
<!--                    <p class="boxed-data">-->
<!--                        < ?php-->
<!--                        echo '-'; // TODO add project name when plugin Project Management will be available-->
<!--                        ?>-->
<!--                    </p>-->
<!--                </div>-->
                <div class="col-sm-3 col-xs-12">
                    <label><?= $model->getAttributeLabel('seats_available'); ?></label>
                    <p class="boxed-data"><?= ($model->seats_available) ? $model->seats_available : '-' ?></p>
                </div>
            </div>
            <div class="widget-body-content col-xs-12 nop">
                <?= \lispa\amos\core\forms\editors\socialShareWidget\SocialShareWidget::widget([
                    'mode' => \lispa\amos\core\forms\editors\socialShareWidget\SocialShareWidget::MODE_DROPDOWN,
                    'model' => $model,
                    'configuratorId'  => 'socialShare',
                    'url'           => \yii\helpers\Url::to(\Yii::$app->params['platform']['backendUrl'].'/events/event/view?id='.$model->id, true),
                    'title'         => $model->getTitle(),
                    'description'   => $model->getDescription(true),
//                'imageUrl'      => !empty($model->getDiscussionsTopicImage()) ? $model->getDiscussionsTopicImage()->getWebUrl('square_small') : '',
                ]); ?>
            </div>
        </div>
        <div class="sidebar col-sm-5 col-xs-12">
            <?= AmosEvents::t('amosevents', 'Informations'); ?>
            <div class="container-sidebar col-xs-12 nop">
                <div class="box col-xs-12 nop">
                    <div class="col-sm-6">
                        <span><?= $model->getAttributeLabel('begin_date_hour'); ?></span>
                        <p class="boxed-data"><?= \Yii::$app->getFormatter()->asDatetime($model->begin_date_hour) ?></p>
                    </div>

                    <div class="col-sm-6">
                        <span><?= $model->getAttributeLabel('end_date_hour'); ?></span>
                        <p class="boxed-data"><?= ($model->end_date_hour ? \Yii::$app->getFormatter()->asDatetime($model->end_date_hour) : '-') ?></p>
                    </div>

                    <div class="col-xs-12">
                        <span><?= AmosEvents::t('amosevents', 'Location') ?></span>
                        <p class="boxed-data">
                            <?= ($model->event_location) ? $model->event_location : '-' ?>
                        </p>
                    </div>
                    <div class="col-xs-12">
                        <p class="boxed-data">
                            <?= ($model->event_address) ? $model->event_address . ', ' : '-' ?>
                            <?= ($model->event_address_house_number) ? $model->event_address_house_number : '-' ?>
                        </p>
                    </div>
                    <div class="col-xs-12 inline-boxed">
                        <div class="col-md-2 col-sm-12">
                            <p class="boxed-data ">
                                <?= ($model->event_address_cap) ? $model->event_address_cap : '-' ?>
                            </p>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <p class="boxed-data">
                                <?= ($model->cityLocation) ? $model->cityLocation->nome . ' ' : '-' ?>
                                <?= ($model->provinceLocation) ? ' (' . $model->provinceLocation->sigla . ') ' : '-' ?>
                            </p>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <p class="boxed-data">
                                <?= ($model->countryLocation) ? $model->countryLocation->nome . ' ' : '-' ?>
                            </p>
                        </div>
                    </div>

                    <?php
                    $module = \Yii::$app->getModule(AmosEvents::getModuleName());
                    if($module->enableGoogleMap){ ?>
                        <div class="col-xs-12">
                            <?= MapWidget::Widget(['position' => $position, 'markerTitle' => $model->event_location, 'zoom' => 10]) ?>
                        </div>
                    <?php } ?>
                    <div class="col-sm-6">
                        <span><?= $model->getAttributeLabel('registration_limit_date'); ?></span>
                        <p class="boxed-data"><?= ($model->registration_limit_date) ? Yii::$app->getFormatter()->asDate($model->registration_limit_date) : '-' ?></p>
                    </div>

                    <div class="col-xs-12">
                        <?php
                        $showButton = ($communityPresent && ($model->status == Event::EVENTS_WORKFLOW_STATUS_PUBLISHED));
                        $button = [
                            'text' => '',
                            'url' => '#',
                            'options' => [
                                'class' => 'btn btn-primary pull-right',
                            ]
                        ];
                        $label = '';

                        $userInList = 0;
                        $userStatus = '';
                        /** @var CommunityUserMm $userCommunity */
                        foreach ($model->communityUserMm as $userCommunity) { // User not yet subscribed to the event
                            if ($userCommunity->user_id == Yii::$app->user->id) {
                                $userInList = 1;
                                $userStatus = $userCommunity->status;
                                break;
                            }
                        }

                        if(!is_null($model->registration_limit_date)){
                            $today = date('Y-m-d');
                            if($today > $model->registration_limit_date){
                                $messagge = AmosEvents::t('amosevents', '#registration_limit_date_expired');
                            }
                        }

                        if (!$userInList) {
                            $button['text'] = AmosEvents::t('amosevents', 'Subscribe');
                            $button['url'] = ['/events/event/subscribe', 'eventId' => $model->id];
                            $button['options']['data']['confirm'] = isset($messagge) ? $messagge : AmosEvents::t('amosevents', 'Do you really want to subscribe?');
                        } else {
                            switch ($userStatus) {
                                case CommunityUserMm::STATUS_WAITING_OK_COMMUNITY_MANAGER:
                                    $button['text'] = AmosEvents::t('amosevents', 'Request sent');
                                    $button['options']['class'] .= ' disabled';
                                    break;
                                case CommunityUserMm::STATUS_WAITING_OK_USER:
                                    $button['text'] = AmosEvents::t('amosevents', 'Accept invitation');
                                    $button['url'] = ['/community/community/accept-user', 'communityId' => $model->community_id, 'userId' => Yii::$app->user->id];
                                    $button['options']['data']['confirm'] = isset($messagge) ? $messagge : AmosEvents::t('amosevents', 'Do you really want to accept invitation?');
                                    break;
                                case CommunityUserMm::STATUS_ACTIVE:
                                    if ($model->event_membership_type_id == EventMembershipType::TYPE_OPEN) {
                                        $label = AmosEvents::t('amosevents', 'Already subscribed');
                                    }
                                    if ($model->event_membership_type_id == EventMembershipType::TYPE_ON_INVITATION) {
                                        $label = AmosEvents::t('amosevents', 'Invitation accepted');
                                    }
                                    $createUrlParams = [
                                        '/community/join',
                                        'id' => $model->community_id
                                    ];
                                    $button['text'] = AmosEvents::t('amosevents', 'Go to the community');
                                    $button['url'] = Yii::$app->urlManager->createUrl($createUrlParams);
                                    break;
                            }
                        }

                        ?>
                        <div class="pull-left">
                            <?= $label ?>
                        </div>

                        <?php if ($showButton): ?>
                            <?= Html::a($button['text'], $button['url'], $button['options']) ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>


        <?php
        $visualizationsNum = 0; // ($model->hits) ? $model->hits : 0;
        $attachmentsNum = 0; // count($model->attachmentsForItemView);
        $tagsNum = 0;  // TODO
        ?>
    </div>
    <?php $this->endBlock(); ?>

    <?php
    $itemsTab[] = [
        'label' => AmosEvents::t('amosevents', 'Overview'),
        'content' => $this->blocks['overview'],
        'options' => ['id' => 'tab-overview'],
    ];
    ?>

    <?php $this->beginBlock('organization'); ?>
    <div class="col-xs-12 nop">
        <h3><?= \lispa\amos\core\icons\AmosIcons::show('info-outline') ?><?= AmosEvents::tHtml('amosevents', 'Event Organization') ?></h3>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('publish_in_the_calendar'); ?></span>
            <span class="boxed-data"><?= ($model->publish_in_the_calendar) ? Yii::$app->getFormatter()->asBoolean($model->publish_in_the_calendar) : '-' ?></span>
        </div>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('event_management'); ?></span>
            <span class="boxed-data"><?= ($model->event_management) ? Yii::$app->getFormatter()->asBoolean($model->event_management) : '-' ?></span>
        </div>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('registration_limit_date'); ?></span>
            <span class="boxed-data"><?= ($model->registration_limit_date) ? Yii::$app->getFormatter()->asDate($model->registration_limit_date) : '-' ?></span>
        </div>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('seats_available'); ?></span>
            <span class="boxed-data"><?= ($model->seats_available) ? $model->seats_available : '-' ?></span>
        </div>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('eventMembershipType'); ?></span>
            <span class="boxed-data"><?= (!is_null($model->eventMembershipType)) ? $model->eventMembershipType->title : '-' ?></span>
        </div>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('paid_event'); ?></span>
            <span class="boxed-data"><?= ($model->paid_event) ? Yii::$app->getFormatter()->asBoolean($model->paid_event) : '-' ?></span>
        </div>
        <div class="col-sm-6">
            <span><?= $model->getAttributeLabel('visible_in_the_calendar'); ?></span>
            <span class="boxed-data"><?= ($model->visible_in_the_calendar) ? Yii::$app->getFormatter()->asBoolean($model->visible_in_the_calendar) : '-' ?></span>
        </div>
    </div>
    <?php $this->endBlock(); ?>

    <?php
    $itemsTab[] = [
        'label' => AmosEvents::t('amosevents', 'Event Organization'),
        'content' => $this->blocks['organization'],
        'options' => ['id' => 'tab-organization'],
    ];
    ?>

    <?php $this->beginBlock('attachments'); ?>
    <div class="attachments col-xs-12 nop">
        <!-- TODO sostituire il tag h3 con il tag p e applicare una classe per ridimensionare correttamente il testo per accessibilità -->
        <h3><?= AmosEvents::tHtml('amosevents', 'Attachments') ?></h3>
        <?= \lispa\amos\attachments\components\AttachmentsTable::widget([
            'model' => $model,
            'attribute' => 'eventAttachments',
            'viewDeleteBtn' => false
        ]) ?>
    </div>
    <?php $this->endBlock(); ?>

    <?php
    $itemsTab[] = [
        'label' => AmosEvents::t('amosevents', 'Attachments'),
        'content' => $this->blocks['attachments'],
        'options' => ['id' => 'tab-attachments'],
    ];
    ?>

    <?php $this->beginBlock('publication'); ?>
    <div class="col-xs-12 nop">
        <h3><?= AmosEvents::tHtml('amosevents', 'Publication') ?></h3>
    </div>
    <?php $this->endBlock(); ?>

    <?php
    //    $itemsTab[] = [
    //        'label' => AmosEvents::t('amosevents', 'Publication'),
    //        'content' => $this->blocks['publication'],
    //        'options' => ['id' => 'tab-publication'],
    //    ];
    ?>

    <?php if ($communityPresent && $model->validated_at_least_once): ?>
        <?php $this->beginBlock('tab-participants'); ?>
        <div class="col-xs-12 nop">
            <h3><?= AmosEvents::tHtml('amosevents', 'Participants') ?></h3>
            <?php
            if (!$model->isNewRecord) {
                echo CommunityMembersWidget::widget([
                    'model' => $model,
                    'showRoles' => [
                        Event::EVENT_PARTICIPANT
                    ],
                    'checkManagerRole' => true,
                    'targetUrlParams' => [
                        'viewM2MWidgetGenericSearch' => true
                    ],
                ]);
            }
            ?>
        </div>
        <?php $this->endBlock(); ?>

        <?php
        $itemsTab[] = [
            'label' => AmosEvents::t('amosevents', 'Participants'),
            'content' => $this->blocks['tab-participants'],
            'options' => ['id' => 'tab-participants'],
        ];
        ?>
    <?php endif; ?>

    <?php $this->beginBlock('feedback'); ?>
    <div class="attachments col-xs-12 nop">
        <h3><?= AmosEvents::tHtml('amosevents', 'Feedback') ?></h3>
    </div>
    <?php $this->endBlock(); ?>

    <?php
    //    $itemsTab[] = [
    //        'label' => AmosEvents::t('amosevents', 'Feedback'),
    //        'content' => $this->blocks['feedback'],
    //        'options' => ['id' => 'tab-feedback'],
    //    ];
    ?>

    <?php if ($communityPresent && (($model->status != Event::EVENTS_WORKFLOW_STATUS_DRAFT) || $model->validated_at_least_once)): ?>
        <?php $this->beginBlock('staff'); ?>
        <div class="attachments col-xs-12 nop">
            <h3><?= AmosEvents::tHtml('amosevents', 'Staff') ?></h3>
            <?php
            if (!$model->isNewRecord) {
                echo CommunityMembersWidget::widget([
                    'model' => $model,
                    'showRoles' => [
                        Event::EVENT_MANAGER
                    ],
                    'targetUrlParams' => [
                        'viewM2MWidgetGenericSearch' => true
                    ],
                    'viewEmail' => true,
                    'addPermission' => 'EVENT_UPDATE',
                    'manageAttributesPermission' => 'EVENT_UPDATE',
                    'forceActionColumns' => (Yii::$app->user->can('EVENTS_VALIDATOR', ['model' => $model]) || Yii::$app->user->can('PLATFORM_EVENTS_VALIDATOR', ['model' => $model])),
                    'actionColumnsTemplate' => '{confirmManager}{acceptUser}{rejectUser}{relationAttributeManage}{deleteRelation}'
                ]);
            }
            ?>
        </div>
        <?php $this->endBlock(); ?>

        <?php
        $itemsTab[] = [
            'label' => AmosEvents::t('amosevents', 'Staff'),
            'content' => $this->blocks['staff'],
            'options' => ['id' => 'tab-staff'],
        ];
        ?>
    <?php endif; ?>

    <?= Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]);
    ?>

    <?= CloseButtonWidget::widget([
        'title' => AmosEvents::t('amosevents', 'Close'),
        'layoutClass' => 'pull-right',
        'urlClose' => Yii::$app->session->get('previousUrl')
    ]) ?>
</div>
