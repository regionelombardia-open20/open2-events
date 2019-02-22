<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
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
 * @var \lispa\amos\events\models\Event $model
 * @var $this View
 */

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
?>

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