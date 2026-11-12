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
 */


$jsAjax = <<<JS

$('body').on('click', '.fc-basicDay-view .fc-content', function (e) {
	
    //e.preventDefault();
	
	var attrId = $(this).attr('id');
    var attrIdSplit = attrId.split('-');
	var id = attrIdSplit[attrIdSplit.length-1];
	
	location.href = window.location.origin + '/events/event/view?id=' + id;
	
    /*
    $.pjax({
	    type: "POST",
	    url: "events/event/event-calendar-widget#container-calendary",
	    data: { id:  id},
	    push: false,
	    container: '#event-calendar-pjax'
    });*/
 });

JS;
$this->registerJs($jsAjax, View::POS_READY);


