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

use open20\amos\core\forms\CloseButtonWidget;
use open20\amos\events\AmosEvents;

/**
 * @var yii\web\View $this
 * @var \open20\amos\events\models\Event $event
 */

$this->title = AmosEvents::txt('#event_signup_thankyou_waiting');
$this->params['breadcrumbs'][] = $this->title;

?>

<h3><?= AmosEvents::txt('Grazie di esserti registrato.'); ?></h3>
<h3><?= AmosEvents::txt('#event_signup_thankyou_msg_1'); ?></h3>
<h3><?= AmosEvents::txt('#event_signup_thankyou_msg_2'); ?></h3>
<div class="btnViewContainer pull-left">
    <?= CloseButtonWidget::widget([
        'title' => AmosEvents::t('amosevents', '#go_back_to_event'),
        'layoutClass' => 'pull-left',
        'urlClose' => $event->getFullViewUrl()
    ]); ?>
</div>
