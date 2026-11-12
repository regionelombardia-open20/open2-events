<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   retecomuni\frontend\views\site\parts
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

?>

<div class="calendary">
    <?= \open20\amos\core\views\CalendarView::widget([
        'dataProvider' => $events,
        'itemView' => '_calendar',
        'clientOptions' => [
            'locale' => 'IT',
            'buttonText' => [
                'month' => AmosEvents::t('amosevents', '#month_view')
            ],
            'height' => 'auto',
            'navLinks' => true,
            'header' => [
                'left' => 'prev,next',
                'center' => 'title',
                'right' => 'month'
            ],
            'dayNamesShort' => ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
            'eventBackgroundColor' => '#FC511D',
        ],
        'eventConfig' => [
            'id' => 'id',
            'title' => 'eventTitle',
            'start' => 'begin_date_hour',
            'end' => 'end_date_hour',
            'color' => 'eventColor',
            'url' => 'eventUrl',
        ],
        'array' => false,
        //se ci sono più eventi legati al singolo record
        //'getEventi' => 'getEvents'//funzione da abilitare e implementare nel model per creare un array di eventi legati al record
    ]) ?>
</div>
