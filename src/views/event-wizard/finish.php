<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\event-wizard
 * @category   CategoryName
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\events\AmosEvents;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\events\models\Event $model
 * @var string $finishMessage
 */

$this->title = AmosEvents::t('amosevents',"Nuovo Evento");
?>

<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">
            <h3><?= $finishMessage ?></h3>
            <h4><?= AmosEvents::tHtml('amosevents', "Clic on 'back to events' to finish.") ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= Html::a(AmosEvents::tHtml('amosevents', 'Back to events'), ['/events/event/index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
