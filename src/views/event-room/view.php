<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\views\event-room
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

use open20\amos\core\forms\ContextMenuWidget;
use open20\amos\core\helpers\Html;
use open20\amos\events\AmosEvents;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var \open20\amos\events\models\EventRoom $model
 */

$this->title = $model->room_name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="event-room-view col-xs-12 m-t-5">
    <div class="row">
        <div class="col-xs-12 m-b-5">
            <?= ContextMenuWidget::widget([
                'model' => $model,
                'actionModify' => $model->getFullUpdateUrl(),
                'actionDelete' => $model->getFullDeleteUrl()
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'room_name',
                    'available_seats'
                ],
            ]) ?>
        </div>
    </div>
    <div class="btnViewContainer pull-right">
        <?= Html::a(AmosEvents::t('amosevents', 'Close'), Yii::$app->session->get(AmosEvents::beginCreateNewSessionKey()), ['class' => 'btn btn-secondary']); ?>
    </div>
</div>
