<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\views\event-wizard
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

use open20\amos\core\helpers\Html;
use open20\amos\events\AmosEvents;

/**
 * @var yii\web\View $this
 * @var \open20\amos\events\models\Event $model
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
