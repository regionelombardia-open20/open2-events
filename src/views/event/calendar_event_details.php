<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events
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

use open20\amos\core\helpers\Html;
use open20\amos\events\AmosEvents;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var open20\amos\events\models\Event $model
 */

?>

<div class="event-detail-modal">
    <?php
    $attributes = [
        'title',
        'begin_date_hour:datetime',
    ];

    if (!is_null($model->eventType) && $model->eventType->durationRequested) {
        $attributes[] = [
            'label' => $model->getAttributeLabel('length'),
            'value' => $model->length . ' ' . $model->eventLengthMeasurementUnit->title
        ];
    }

    if (!is_null($model->eventType) && $model->eventType->locationRequested) {
        $attributes[] = [
            'label' => AmosEvents::t('amosevents', 'Location'),
            'value' => ($model->country_location_id == 1 ? $model->cityLocation->nome . ' (' . $model->provinceLocation->sigla . '), ' : '') . $model->countryLocation->nome
        ];
    }

    $attributes['eventMembershipType'] = [
        'attribute' => 'eventMembershipType',
        'label' => $model->getAttributeLabel('eventMembershipType'),
        'value' => (!is_null($model->eventMembershipType) ? $model->eventMembershipType->title : '-'),
    ];
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]) ?>
    <?php
    if($model->event_type_id == \open20\amos\events\models\EventType::TYPE_OPEN || $model->event_type_id == \open20\amos\events\models\EventType::TYPE_LIMITED_SEATS) {
        echo Html::a(AmosEvents::t('amosevents', '#event_signup_submit'), ['event-signup', 'eid' => $model->id], ['class' => 'btn btn-primary m-l-5 m-b-15 pull-right']);
    }
    ?>
    <?= Html::a(AmosEvents::t('amosevents', 'Open event'), ['view', 'id' => $model->id], ['class' => 'btn btn-primary m-b-15 pull-right']); ?>
</div>
