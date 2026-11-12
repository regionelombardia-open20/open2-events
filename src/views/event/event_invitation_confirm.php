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

use open20\amos\core\forms\ActiveForm;
use open20\amos\core\helpers\Html;
use open20\amos\events\AmosEvents;

/**
 * @var yii\web\View $this
 * @var open20\amos\events\models\Event $event
 * @var open20\amos\events\models\EventInvitationsUpload $upload
 * @var yii\widgets\ActiveForm $form
 * @var string $fid
 */

$this->title = AmosEvents::txt('#event_invitation_confirm_header');
?>
<?php $form = ActiveForm::begin(); ?>

<div class="event-form">
    <div class="row">
        <div class="header-form">
            <?php
            $url = '/img/img_default.jpg';
            if (!is_null($event->eventLogo)) {
                $url = $event->eventLogo->getWebUrl('original', false, true);
            }
            ?>
            <?= Html::img($url, [
                'title' => $event->getAttributeLabel('eventLogo'),
                'class' => 'img-responsive'
            ]); ?>

            <div class="header-form_caption">
                <div class="form_caption_date text-center">

                    <h2 class="event-day"><?= date("d", strtotime($event->begin_date_hour)) ?></h2>
                    <p class="event-month"><?= Yii::$app->formatter->asDate($event->begin_date_hour, 'MMM') ?></p>
                    <p class="event-year"><?= date("Y", strtotime($event->begin_date_hour)) ?></p>

                    <!--                    < ?= \Yii::$app->getFormatter()->asDatetime($event->begin_date_hour) ?> <br>-->
                    <!--                    < ?= ($event->end_date_hour ? \Yii::$app->getFormatter()->asDatetime($event->end_date_hour) : '-') ?> <br>-->
                </div>
                <div class="form_caption_title">
                    <span><?= ($event->cityLocation) ? $event->cityLocation->nome : '-' ?> </span> <span> | </span>
                    <span><?= ($event->countryLocation) ? $event->countryLocation->nome : '-' ?></span>
                    <h2><?= $event->title ?></h2>
                    <!--                    <p>< ?= $event->summary ?></p>-->
                    <!--                    <p>< ?= $event->description ?></p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="container-mod">
        <div class="row">
            <div class="col-xs-12 event-confirm-description">
                <!-- TODO per grafica: graficare sommario e descrizione -->
                <p><?= $event->summary ?></p>
                <p><?= $event->description ?></p>
                <h2><?= AmosEvents::t('amosevents', 'Conferma iscrizione') ?></h2>
                <h4><?= AmosEvents::t('amosevents', 'ANAGRAFICA ACCOMPAGNATORE') ?></h4>
                <!--            <p>Ciao <strong>Mario Rossi</strong>, puoi confermare la tua Nulla et accumsan ante, tempus bibendum diam.-->
                <!--                Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;-->
                <!--                Proin pretium nulla eu tristique molestie. Phasellus non molestie tortor. Vestibulum a dui a nunc mattis pretium.-->
                <!--                Maecenas magna ex, pretium id finibus et, imperdiet a arcu. Proin in euismod ipsum.-->
                <!--            </p>-->
            </div>
        </div>

        <div class="col-xs-12 event-confirm-form">
            <?php
            if (!is_null($event->eventType) && $event->eventType->partners) {
                foreach ($partners as $i => $partner) {
                    ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <h3><?= ($i + 1) ?></h3>
                        </div>
                        <div class="col-sm-5">
                            <div><?= $form->field($partner, "[$i]name")->textInput() ?></div>
                            <div><?= $form->field($partner, "[$i]surname")->textInput() ?></div>
                        </div>
                        <div class="col-sm-5">
                            <div><?= $form->field($partner, "[$i]fiscal_code")->textInput() ?></div>
                            <div><?= $form->field($partner, "[$i]email")->textInput() ?></div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <div class="text-right">
            <?= Html::submitButton('Conferma iscrizione', ['class' => 'btn']) ?>
        </div>
    </div>

    <!--        < ?= ($event->provinceLocation) ? ' (' . $event->provinceLocation->sigla . ')' : '' ?> <br>-->
    <!--        < ?= $event->description ?>-->
    <!--        < ?= $event->summary ?> <br>-->
    <!--        < ?= ($event->seats_available) ? $event->seats_available : '-' ?> <br>-->

</div>


<?php ActiveForm::end(); ?>
