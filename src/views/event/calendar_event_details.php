<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\events\AmosEvents;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\events\models\Event $model
 */

?>

<div class="event-detail-modal">
    <?php
    $attributes = [
        'title',
        'begin_date_hour:datetime',
    ];

    if ($model->eventType->durationRequested) {
        $attributes[] = [
            'label' => $model->getAttributeLabel('length'),
            'value' => $model->length . ' ' . $model->eventLengthMeasurementUnit->title
        ];
    }

    if ($model->eventType->locationRequested) {
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
    <?= Html::a(AmosEvents::t('amosevents', 'Open event'), ['view', 'id' => $model->id], ['class' => 'btn btn-primary m-b-15 pull-right']) ?>
</div>
