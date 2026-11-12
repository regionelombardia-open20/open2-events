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
 * @var \open20\amos\events\models\Event $eventData
 * @var object $qrcode immagine del qrcode
 * @var array $participantData
 */
?>

<h3><?= $eventData->title ?></h3>

    <p>Ora evento: <?= $eventData->begin_date_hour ?></p>

<br /><br />

<?php
$invitation = $participantData['companion_of'];
if($invitation->is_group){ ?>
    <b>Gruppo: </b> <?= $participantData['nome'] . ' ' .$participantData['cognome'] ?><br />
<?php } else { ?>
    <b>Nome: </b> <?= $participantData['nome'] ?><br />
    <b>Cognome: </b> <?= $participantData['cognome'] ?><br />
    <b>Azienda: </b> <?= $participantData['azienda'] ?><br />
<?php  } ?>
<?php if(!empty($participantData['codice_fiscale'])) : ?> <b>Codice Fiscale</b> <?= $participantData['codice_fiscale'] ?><br /><?php endif; ?>
<b>Note: </b> <?= $participantData['note'] ?><br />

<br /><br />

<?php if($eventData->seats_management) {?>
    <b><?=$participantData['seat']?></b>
<?php }?>

<?php if(!empty($participantData['accreditationModel'])) : ?>
    <b>Lista accreditamento</b> <?= $participantData['accreditationModel']->title; ?>
<?php endif; ?>

<br /><br />

<?php if(!empty($qrcode)) : ?>
Codice <?= $qrcode; ?>
<?php endif; ?>
