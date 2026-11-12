<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\widgets\graphics\views\fullsize
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

use open20\amos\core\forms\WidgetGraphicsActions;
use open20\amos\core\helpers\Html;
use open20\amos\core\icons\AmosIcons;
use open20\amos\events\AmosEvents;
use open20\amos\events\assets\EventsAsset;
use open20\amos\events\widgets\graphics\WidgetGraphicsEvents;
use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;

EventsAsset::register($this);

/**
 * @var \yii\web\View $this
 * @var ActiveDataProvider $listEvents
 * @var \open20\amos\events\models\Event[] $eventsForCarousel
 * @var WidgetGraphicsEvents $widget
 * @var string $toRefreshSectionId
 * @var int $numEvents
 * @var string $orderEvents
 */

$moduleEvents = \Yii::$app->getModule(AmosEvents::getModuleName());
$thereAreEvents = ((count($eventsForCarousel) == 0) ? false : true);

?>
<div class="box-widget-header">
    <?php
    if (isset($moduleEvents) && !$moduleEvents->hideWidgetGraphicsActions) {
        WidgetGraphicsActions::widget([
            'widget' => $widget,
            'tClassName' => AmosEvents::className(),
            'actionRoute' => '/events/event/create',
            'toRefreshSectionId' => $toRefreshSectionId
        ]);
    } ?>

    <div class="box-widget-wrapper">
        <h2 class="box-widget-title">
            <?= AmosIcons::show('eventi', ['class' => 'am-2'], AmosIcons::IC) ?>
            <?= AmosEvents::tHtml('amosevents', 'Ultimi Eventi') ?>
        </h2>
    </div>

    <?php
    if ($thereAreEvents) {
        $textReadAll = AmosEvents::t('amosevents', '#showAll') . AmosIcons::show('chevron-right');;
        $linkReadAll = ['/events/event/all-events'];
        $checkPermNew = false;
    } else {
        $textReadAll = AmosEvents::t('amosevents', '#addEvent');
        $linkReadAll = '/events/event/create';
        $checkPermNew = true;
    }
    ?>
    <div class="read-all"><?= Html::a($textReadAll, $linkReadAll, ['class' => ''], $checkPermNew); ?></div>
</div>

<div class="box-widget latest-events">
    <section>
        <h2 class="sr-only"><?= AmosEvents::t('amosevents', 'Ultimi Eventi') ?></h2>
        <div class="wrap-event">
            <div class="<?= ($thereAreEvents ? 'col-sm-8' : '') ?> col-xs-12 nop" id="event-calendar-pjax">
                <?php Pjax::begin(['id' => $toRefreshSectionId]); ?>

                <?php if (!$thereAreEvents): ?>
                    <div class="list-items list-empty"><h3><?= AmosEvents::t('amosevents', '#no_events') ?></h3></div>
                <?php else: ?>
                    <?php
                    $configuration = [
                        'containerOptions' => [
                            'id' => 'eventsOwlCarousel'
                        ],
                        'pluginOptions' => [
                            'autoplay' => true,
                            'items' => 1,
                            'loop' => true,
                            'nav' => true,
                            'dots' => false
                        ]
                    ];
                    OwlCarouselWidget::begin($configuration);
                    ?>

                    <?php foreach ($eventsForCarousel as $event): ?>
                        <?php /** @var \open20\amos\events\models\Event $event */ ?>
                        <div>
                            <a href="<?= $event->getFullViewUrl() ?>" title="<?= AmosEvents::t('amosevents', '#widget_title_view_event') ?>">
                                <div class="wrap-img">
                                    <?=
                                    Html::img($event->getEventsImageUrl('original', true), [
                                        'alt' => $event->getAttributeLabel('eventLogo'),
                                        'class' => 'img-responsive'
                                    ]);
                                    ?>
                                </div>
                                <div class="abstract">
                                    <h2 class="box-widget-subtitle">
                                        <?= $event->title ?>
                                    </h2>
                                    <h3 class="box-widget-subtitle">
                                        <?= $event->summary ?>
                                    </h3>
                                    <p><?= \Yii::$app->getFormatter()->asDate($event->begin_date_hour) ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>

                    <?php OwlCarouselWidget::end(); ?>

                <?php endif; ?>
                <?php Pjax::end(); ?>
            </div>

            <?php if ($thereAreEvents): ?>
                <div id="container-calendary" class="col-sm-4 col-xs-12 nop container-calendary">
                    <?= $this->render("calendary", ['events' => $listEvents]); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
