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
$this->title = \open20\amos\events\AmosEvents::t('amosevents', 'Prenotazioni');
if ($event) {
    $this->title .= ' '.Yii::t('amosevents', 'for event').' "'.$event->title.'"';
}
$this->params['breadcrumbs'][] = $this->title;

$isLoggedUserPartner = \open20\amos\events\utility\EventsUtility::isLoggedUserPartner($model->id);;
$canViewUser = \Yii::$app->user->can('ADMIN') || $isLoggedUserPartner;

?>
    <div class="col-xs-12 m-b-25">

        <div class="col-xs-12 col-sm-12 col-md-5">
            <h2><?= AmosEvents::t('amosevents', 'Progetto') . ' ' . '<strong>' . $calendar->title . '</strong>' ?></h2>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
            <label><?= AmosEvents::t('amosevents', 'Data inizio') ?></label>
            <h3 class="m-t-0"><?= '<strong>' . Yii::$app->formatter->asDate($model->date) . '</strong>' ?></h3>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-3">
            <label><?= AmosEvents::t('amosevents', 'Orario') ?></label>
            <h3 class="m-t-0"><?= 'dalle <strong>' . Yii::$app->formatter->asTime($model->hour_start, 'HH:mm') . '</strong> alle <strong>' . Yii::$app->formatter->asTime($model->hour_end, 'HH:mm') . '</strong>' ?></h3>
        </div>

    </div>


<?php echo \open20\amos\core\views\AmosGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'eventCalendarsSlots.eventCalendars.title',
            'format' => 'html',
            'label' => AmosEvents::t('amosevents', 'Progetto'),
        ],
        [
            'attribute' => 'eventCalendarsSlots.date',
            'format' => 'date'
        ],
        [
            'attribute' => 'eventCalendarsSlots.hour_start',
            'format' => 'time'
        ],
        [
            'attribute' => 'eventCalendarsSlots.hour_end',
            'value' => function ($model) {
                return $model->eventCalendarsSlots->getEndHourWithPause();
            },
        ],
        [
            'value' => function ($model) {
                return $model->user->userProfile->nomeCognome;
            },
            'label' => AmosEvents::t('amosevents', 'Prenotato da'),

        ],
        [
            'attribute' => 'affiliation',
//            'visible' => $isLoggedUserPartner
        ],
        [
            'attribute' => 'cellphone',
//            'visible' => $isLoggedUserPartner
        ],

    ]
]);

?>
<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?=
    \yii\helpers\Html::a(Yii::t('amoscore', 'Chiudi'),
        (!empty($urlGet) ? $urlGet : ['/events/event-calendars/view', 'id' => $calendar->id,]),
        ['class' => 'btn btn-secondary']);
    ?>
</div>
