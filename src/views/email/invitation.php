<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\views\email
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
 * @var \open20\amos\core\user\User $user
 */

?>

<h2><?= $event->title ?></h2>
<p><?= $event->summary ?></p>

<p>Ciao <?= $user['name'], ' ', $user['surname'] ?>, sei stato invitato a questo evento.</p>

Partecipi? <a href="<?= $url_yes ?>">Sì</a>, <a href="<?= $url_no ?>">no</a>

<br><br>

<?php if(isset(\Yii::$app->params['googleApi'])): ?>
<a href="<?= \yii\helpers\Url::to(['/events/wallet/save-to-google', 'id' => $event->id], 'https'); ?>">
    <?= AmosEvents::t('amosevents', 'Save To Google Pay'); ?>
</a>
<?php endif; ?>
<?php if(isset(\Yii::$app->params['appleApi'])): ?>
<a href="<?= \yii\helpers\Url::to(['/events/wallet/save-to-ios', 'id' => $event->id], 'https'); ?>">
    <?= AmosEvents::t('amosevents', 'Save To Apple Wallet'); ?>
</a>
<?php endif; ?>