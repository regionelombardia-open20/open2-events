<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   retecomuni\frontend\views\site\parts
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
 * @var \open20\amos\events\models\Event $model
 */

use yii\helpers\Html;


$likEventDetail = '/events/event/view?id=' . $model->id;


$format = Yii::$app->getFormatter();
if ($model->begin_date_hour && $model->end_date_hour) {
    $beginDate = $format->asDate($model->begin_date_hour, 'full');
    $endDate = $format->asDate($model->end_date_hour, 'full');
    $beginTime = $format->asTime($model->begin_date_hour, 'HH:mm');
    $endTime = $format->asTime($model->end_date_hour, 'HH:mm');
    if ($beginDate == $endDate) {
        $date = ucfirst($beginDate); //.' dalle '.$beginTime .' alle '.$endTime;
    } else {
        $date = 'Da ' . $beginDate . /* ' alle '. $beginTime . */
                ' a ' . $endDate; //. ' alle '.$endTime;
    }
} else if ($model->begin_date_hour) {
    $beginDate = $format->asDate($model->begin_date_hour, 'full');
    $date = ucfirst($beginDate);
} else if ($model->end_date_hour) {
    $endDate = $format->asDate($model->end_date_hour, 'full');
    $date = ucfirst($endDate);
}
?>


<div class="col-md-8 col-xs-12 nop">
    <div id="event-<?= $model->id ?>" class="event">


        <div class="container-event">

            <?php
            $url = '/img/img_default.jpg';
            if (!is_null($model->eventLogo)) {
                $url = $model->eventLogo->getUrl('original', false, true);
            }
            ?>
            <div class="wrap-img">
            <?=
            Html::img($url, [
                'alt' => $model->getAttributeLabel('eventLogo'),
                'class' => 'img-responsive'
            ]);
            ?>
            </div>
            <div class="abstract">
                <h2 class="box-widget-subtitle">
                    <a href="<?= $likEventDetail ?>" title="<?= $model->getTitle() ?>" data-pjax="0">
                        <?= $model->getTitle() ?>
                    </a>
                </h2>
                <h3 class="box-widget-subtitle">
                <?= $model->summary ?>
                </h3>
                <div class="container-date col-xs-12 nop">
                    <div class="col-xs-10 nop">
<!--                <span class="am am-chevron-right"></span>-->
<!--                <span class="am am-chevron-right"></span>-->
                        <span class="date"><?= $date ?>
                        </span>
                    </div>
                    <div class="col-xs-2 nop">
                        <span class="dash dash-calendar"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>