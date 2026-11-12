<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\views\event
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

/**
 * @var \open20\amos\events\models\Event $event
 * @var \open20\amos\core\user\User $user Main user
 * @var \open20\amos\admin\models\UserProfile $profile Main user profile
 * @var array $partner partner data
 * @var string $urlYes
 * @var string $urlNo
 */

/** @var AmosEvents $eventsModule */
$eventsModule = AmosEvents::instance();

?>

<h2><?= $event->title ?></h2>
<p><?= $event->summary ?></p>

<p><?= AmosEvents::t('amosevents', '#email_invitation_partner_text', [
        'nomeCognomeAccompagnatore' => $partner['name'], ' ', $partner['surname'],
        'nomeCognomePartecipante' => $profile->getNomeCognome()
    ]); ?></p>

<a href="<?= $urlYes ?>"><?= AmosEvents::t('amosevents', '#email_invitation_partner_yes'); ?></a>
<?php if ($eventsModule->saveExternalInvitations): ?>
    <a href="<?= $urlNo ?>"><?= AmosEvents::t('amosevents', '#email_invitation_partner_no'); ?></a>
<?php endif; ?>
