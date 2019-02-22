<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\email
 * @category   CategoryName
 */

use lispa\amos\events\AmosEvents;

/**
 * @var \lispa\amos\events\models\Event $event
 */

?>

<?= AmosEvents::t('amosevents', 'The event') . " '" . $event->title . "' " . AmosEvents::t('amosevents', 'has been published') . '.'; ?>
