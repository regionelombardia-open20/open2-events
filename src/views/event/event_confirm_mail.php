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

/**
 * @var \open20\amos\admin\models\UserProfile $userProfile
 * @var array $companions
 * @var string $communityLink
 * @var string $removeInvitationLink
 * @var string $downloadIcsLink
 * @var \open20\amos\events\models\Event $event
 * @var \open20\amos\events\models\EventInvitation $invitation
 */

use open20\amos\events\helpers\google_api\widgets\AddEventTicketWidget;

?>

<p><?= \open20\amos\events\AmosEvents::txt('Gentile {name_surname}', ['name_surname' => $userProfile->getNomeCognome()]) ?>
    ,</p>
<p><?= \open20\amos\events\AmosEvents::txt(
        'Ti confermiamo l\'iscrizione all\'evento {event_title} che si svolgerà dal {event_date} al {event_end_date}', [
        'event_title' => $event->title,
        'event_date' => Yii::$app->getFormatter()->asDatetime($event->begin_date_hour, 'humanalwaysdatetime'),
        'event_end_date' => Yii::$app->getFormatter()->asDatetime($event->end_date_hour, 'humanalwaysdatetime')
    ]) ?></p>
<p><?= $userProfile->getNomeCognome(); ?></p>
<?php
foreach ($companions as $companion) {
    echo "<p>{$companion['nome']} {$companion['cognome']}</p>";
}
?>
<br/>
<p><?= $event->description; ?></p>
<br/>
<p><?= $event->getFullAddress("<br />") ?></p>
<?php if ($event->show_community): ?>
    <br/>
    <p><?= \yii\helpers\Html::a(\open20\amos\events\AmosEvents::txt('Se desideri partecipare alla community dell’evento clicca qui: potrai trovare notizie, documenti e altro materiale pubblicato per te'), $communityLink); ?></p>
<?php endif; ?>
<br/>
<p><?= \yii\helpers\Html::a(\open20\amos\events\AmosEvents::txt('Se desideri annullare la tua iscrizione all’evento, clicca qui.'), $removeInvitationLink) ?></p>
<p><?= \yii\helpers\Html::a(\open20\amos\events\AmosEvents::txt('Per scaricare il file calendario (.ics), clicca qui.'), $downloadIcsLink) ?></p>

