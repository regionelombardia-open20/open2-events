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

use open20\design\assets\BootstrapItaliaDesignAsset;
use open20\design\utility\DateUtility;
use Yii;

$currentAsset = BootstrapItaliaDesignAsset::register($this);

if (!is_null($model->eventLogo)) {
    $urlImage = $model->eventLogo->getWebUrl('dashboard_news', false, true);
}

$tags = $model->getTagsList();
$dayStart = \Yii::$app->formatter->asDate($model->begin_date_hour, 'php:d');
$monthStart = \Yii::$app->formatter->asDate($model->begin_date_hour, 'php:F');
$yearStart = \Yii::$app->formatter->asDate($model->begin_date_hour, 'php:Y');
$hourStart = \Yii::$app->formatter->asDatetime($model->begin_date_hour, 'php:H:i');
?>





<div class="detail-event-container">

    <!--CONTENUTO, IN FASE 1 A UNA COLONNA-->
    <div class="event-content container py-5">
        <div class="row">
            <div class="col-sm-12 col-md-8 pr-sm-5">
                <div class="d-flex">
                    <span class="event-badge badge bg-primary text-uppercase text-white font-weight-bold"><?= Yii::t('amosplatform', 'Eventi') ?></span>
                </div>
                <p class="event-title pt-2 font-weight-bold mb-1"><?= $model->title ?></p>
                <p class="event-summary font-weight-normal"><?= ($model->begin_date_hour) ? $dayStart . ' ' . $monthStart . ' ' . $yearStart . ($model->filo_allday == 1 ? ' ' . \Yii::t('amosapp', 'tutto il giorno') : (' ' . \Yii::t('amosapp', 'ore') . ' ' . $hourStart)) : '' ?> <?= ($model->event_location) ? ', ' . $model->event_location : '' ?></p>
                <img src="<?= $urlImage ?>" class="detail-event-image my-4 figure-img rounded img-fluid" alt="<?= Yii::t('amosplatform', 'Immagine evento') ?>">
                <p>
                    <?= \Yii::$app->formatter->asHtml($model->description) ?>
                </p>              
                <?php if (!empty($tags)): ?>
                    <div class="tag-container">
                        <?php foreach ($tags as $tag): ?>
                            <span class="badge rounded-pill bg-100"><?= $tag ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <p class="event-disclaimer mt-5">
                    <?= Yii::t('site', '#event_disclaimer') ?>  
                </p>


            </div>
            <div class="col-sm-12 col-md-4 right-column">
            </div>
        </div>

    </div>

</div>