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

use yii\bootstrap\Modal;
use yii\web\View;

/*
 * Personalizzare a piacimento la vista
 * $model è il model legato alla tabella del db
 * $buttons sono i tasti del template standard {view}{update}{delete}
 * tutto quello che si inserirà qui comparirà dopo il calendario per inserire
 * del codice HTML prima del calendario usare il campo intestazione della
 * configurazione della vista nella pagina index.php
 */
/**
 * @var \open20\amos\events\models\Event $model
 * @var $this View
 */

// Modal render for each event (previous code)
/*
$jsAjax = <<<JS

$('body').on('click', '.fc-content', function (e) {
    $.ajax({
	    type: "POST",
	    url: "get-event-by-id",
	    data: { id: $(this).attr('id') },
	    cache: false,
	    success: function(response){
            $('#event-modal-body').html(response);
            $('#event-modal').modal('show');
    	}
    });
});

JS;

$this->registerJs($jsAjax, View::POS_READY);

// END PHP TAG
?
>
<div class="event-modal">
    <?php
    Modal::begin([
        'options' => [
            'id' => 'event-modal',
            'tabindex' => false,
        ],
        'size' => Modal::SIZE_LARGE,
        'header' => '<span class="event-modal-title"></span>',
    ]);
    ?>
    <div class="event-modal-body" id="event-modal-body"></div>
    <?php
    Modal::end();
    ?>
</div>

*/

// Open the event page directly without modals
$this->registerJs(<<<JS
    if(typeof globalCalendar == 'undefined'){
            globalCalendar = [];
    }
    globalCalendar[parseInt({$model->id}, 10)] = "{$model->getFullViewUrl()}";
    $('body').on('click', '.fc-content', function (e) {
        var elemId = $(this).attr('id').toString();
        var titleEl = $(this).data('title');
        if(elemId !== undefined && elemId !== "") {    
            eventId = parseInt(elemId.split("-")[2],10);
            window.open(globalCalendar[eventId], "_self");
        }
    });
JS
    );
