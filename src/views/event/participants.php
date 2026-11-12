<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\community\views\community
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

use open20\amos\community\AmosCommunity;
use open20\amos\community\widgets\CommunityMembersWidget;
use yii\widgets\Pjax;

$this->title = \Yii::t('amoscommunity', 'Participants');
$this->params['breadcrumbs'][] = ['label' => Yii::t('amoscommunity', 'Community'), 'url' => ['join', 'id' => $model->community_id]];
$this->params['breadcrumbs'][] = $this->title;

$sendTicketsLabel = \open20\amos\events\AmosEvents::txt('Send tickets');

$this->registerJs(<<<JS
    $(document).on("pjax:timeout", function(event) {

    // Prevent default timeout redirection behavior

    event.preventDefault()

});
JS
    , \yii\web\View::POS_LOAD);

Pjax::begin(['timeout' => 10000, 'id' => 'pjax-participants-widget']);

echo \open20\amos\events\widgets\CommunityEventMembersWidget::widget([
    'model' => $model,
    'targetUrlParams' => [
        'viewM2MWidgetGenericSearch' => true,
    ],
    'checkManagerRole' => true,
    'pjaxId' => 'pjax-participants-widget',
    'pageUrl' => '/events/event/participants?communityId=' . $model->community_id,
    'showAdditionalAssociateButton' => $model->has_tickets,
    'enableAdditionalButtons' => true,
]);

Pjax::end();