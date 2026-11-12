<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\views\event
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

use open20\amos\core\icons\AmosIcons;
use open20\amos\events\AmosEvents;
use open20\amos\events\assets\EventsAsset;
use open20\amos\events\models\search\EventTypeSearch;

/**
 * @var yii\web\View $this
 * @var mixed $model_type
 * @var open20\amos\events\models\search\EventSearch $model
 * @var open20\amos\events\AmosEvents $eventsModule
 * @var string $originAction
 */

EventsAsset::register($this);

$eventTypes = EventTypeSearch::listEnabledGenericContextEventTypesAndIcon();
$arrayCssClass = EventTypeSearch::ARRAYCSSCLASS;

?>
<?php if ($eventsModule->showEventLegend): ?>
    <div class="event-legenda callout callout-info m-b-30">
        <div class="callout-title">
            <span><?= AmosEvents::t('amosevents', 'Legenda') ?></span>
        </div>
        <div class="flexbox flexbox-row flexbox-wrap">
            <?php foreach ($eventTypes as $eventType): ?>
                <div class="event-status <?= $arrayCssClass[$eventType['type']]; ?>">
                    <p><?= AmosIcons::show($eventType['icon'], ['style' => "background-color:" . $eventType['color'] . "; color:" . EventTypeSearch::colorText($eventType['color'])]) . ' ' . AmosEvents::t('amosevents', $eventType['title']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
