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
use open20\amos\core\helpers\Html;
use open20\amos\core\views\DataProviderView;
use yii\widgets\Pjax;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
 * @var open20\amos\events\models\search\EventAccreditationListSearch $model
*/

$this->title = Yii::t('amoscore', 'Event Accreditation List');
$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['/events']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-accreditation-list-index">
                <?=   $this->render('_search', ['model' => $model, 'originAction' => Yii::$app->controller->action->id ]); ?>
    
            <?= DataProviderView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $model,
   'currentView' => $currentView,
   'gridView' => [
   'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'event_id',

                        'event' => [
                        'attribute' => 'event',
                        'format' => 'html',
                        'label' => '',
                        'value' => function($model){
                        return strip_tags($model->event);
                        }
                        ],
                                'position',
            'title',
        [
        'class' => 'open20\amos\core\views\grid\ActionColumn',
        ],
        ],
        ],
        /*'listView' => [
        'itemView' => '_item',
        'masonry' => FALSE,

        // Se masonry settato a TRUE decommentare e settare i parametri seguenti 
        // nel CSS settare i seguenti parametri necessari al funzionamento tipo
        // .grid-sizer, .grid-item {width: 50&;}
        // Per i dettagli recarsi sul sito http://masonry.desandro.com                                     

        //'masonrySelector' => '.grid',
        //'masonryOptions' => [
        //    'itemSelector' => '.grid-item',
        //    'columnWidth' => '.grid-sizer',
        //    'percentPosition' => 'true',
        //    'gutter' => '20'
        //]
        ],
        'iconView' => [
        'itemView' => '_icon'
        ],
        'mapView' => [
        'itemView' => '_map',          
        'markerConfig' => [
        'lat' => 'domicilio_lat',
        'lng' => 'domicilio_lon',
        'icon' => 'iconMarker',
        ]
        ],
        'calendarView' => [
        'itemView' => '_calendar',
        'clientOptions' => [
        //'lang'=> 'de'
        ],
        'eventConfig' => [
        //'title' => 'titleEvent',
        //'start' => 'data_inizio',
        //'end' => 'data_fine',
        //'color' => 'colorEvent',
        //'url' => 'urlEvent'
        ],
        'array' => false,//se ci sono più eventi legati al singolo record
        //'getEventi' => 'getEvents'//funzione da abilitare e implementare nel model per creare un array di eventi legati al record
        ]*/
        ]); ?>
    
</div>
