<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-events
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

use open20\amos\events\AmosEvents;
use open20\amos\core\icons\AmosIcons;
use open20\amos\core\views\grid\ActionColumn;

/**
 * @var yii\web\View $this
 * @var open20\amos\events\models\EventCalendars $model
 */
$this->title = \open20\amos\events\AmosEvents::t('amosevents', 'Le mie prenotazioni');
if ($event) {
    $this->title .= ' '.Yii::t('amosevents', 'for event').' "'.$event->title.'"';
}
$this->params['breadcrumbs'][] = $this->title;


echo \open20\amos\core\views\AmosGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'eventCalendars.title',
            'format' => 'html',
            'label' => AmosEvents::t('amosevents', 'Progetto'),
        ],
        [
            'attribute' => 'date',
            'format' => 'date'
        ],
        [
            'attribute' => 'hour_start',
            'format' => 'time'
        ],
        [
            'attribute' => 'hour_end',
            'value' => function ($model) {
                return $model->getEndHourWithPause();
            },
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{book}',
            'buttons' => [
                'book' => function ($url, $model) {
                    return \yii\helpers\Html::a(\open20\amos\core\icons\AmosIcons::show('calendar-check-o', [],
                                'dash'), ['/events/event-calendars/view', 'id' => $model->eventCalendars->id],
                            [
                            'class' => 'btn btn-primary',
                            'title' => AmosEvents::t('amosevents', "Gestisci appuntamento"),
                    ]);
                }
            ]
        ]
    ]
]);
