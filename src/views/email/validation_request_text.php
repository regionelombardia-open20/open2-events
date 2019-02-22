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
 * @var \lispa\amos\core\user\User $user
 */

?>

<h2>
    <?= AmosEvents::t('amosevents', 'Has been requested the validation for event'); ?>
</h2>
<?= AmosEvents::t('amosevents', 'Event type') . ': ' . $event->eventType->title . '<br>'; ?>
<?= AmosEvents::t('amosevents', 'Event title') . ': ' . $event->title . '<br>'; ?>
<?= AmosEvents::t('amosevents', 'Event summary') . ': ' . $event->summary . '<br>'; ?>
<?= AmosEvents::t('amosevents', 'Published by') . ': ' . $user->userProfile->getNomeCognome(); ?>
