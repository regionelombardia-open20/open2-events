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

/** @var $sector String
 *  @var $dataProvider \yii\data\ActiveDataProvider
 *  @var $model \open20\amos\events\models\Event
 */
use open20\amos\events\AmosEvents;

$this->title = strip_tags($model->title) ." ". AmosEvents::t('amosevents', 'settore')." '$sector'";
$this->params['breadcrumbs'][] = ['label' => Yii::$app->session->get('previousTitle'), 'url' => Yii::$app->session->get('previousUrl')];
$this->params['breadcrumbs'][] = $this->title;

/** @var AmosEvents $eventsModule */
$eventsModule = AmosEvents::instance();

?>

<div class="col-xs-12">
    <h2><?= $this->title ?></h2>
    <?= \yii\helpers\Html::a(AmosEvents::t('amosevents', 'Indietro'), ['view','id' => $model->id, '#' => 'tab-seats_management'],  [
            'class' => 'btn btn-navigation-secondary'
    ]);?>
    <?= \open20\amos\core\views\AmosGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'row',
            'seat',
            [
                'attribute' => 'automatic',
                'format' => 'boolean'
            ],
            [
                'attribute' => 'available_for_groups',
                'format' => 'boolean'
            ],
            [
                'attribute' => 'stringSeatAssignedTo',
                'label' => AmosEvents::t('amosevents', 'Assegnato a')

            ],
             [
                'attribute' => 'labelStatus',
                'label' => AmosEvents::t('amosevents', 'Status')
            ],
        ]
    ])?>

</div>
