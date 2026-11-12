<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events
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

use open20\amos\core\interfaces\CmsModuleInterface;
use open20\amos\events\AmosEvents;
use yii\data\ActiveDataProvider;

/**
 * @var yii\web\View $this
 * @var open20\amos\events\models\Event $model
 * @var open20\amos\events\models\EventInvitationsUpload $upload
 * @var int $countEventTypes
 * @var bool $enableAgid
 * @var \amos\sitemanagement\Module|AmosModule|CmsModuleInterface|null $siteManagementModule
 * @var \amos\sitemanagement\models\SiteManagementSlider|null $imageSlider
 * @var ActiveDataProvider|null $dataProviderImageSlider
 * @var \amos\sitemanagement\models\SiteManagementSlider|null $videoSlider
 * @var ActiveDataProvider|null $dataProviderVideoSlider
 * @var string|null $fid
 * @var string|null $dataField
 * @var open20\amos\cwh\AmosCwh $moduleCwh
 * @var array $scope
 */

$this->title = AmosEvents::t('amosevents', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::$app->session->get('previousTitle'), 'url' => Yii::$app->session->get('previousUrl')];
$this->params['breadcrumbs'][] = $this->title;

$formToRender = ($enableAgid ? '_formAgid' : '_form');

?>
<div class="event-update">
    <?= $this->render($formToRender, [
        'model' => $model,
        'countEventTypes' => $countEventTypes,
        'enableAgid' => $enableAgid,
        'siteManagementModule' => $siteManagementModule,
        'imageSlider' => $imageSlider,
        'dataProviderImageSlider' => $dataProviderImageSlider,
        'videoSlider' => $videoSlider,
        'dataProviderVideoSlider' => $dataProviderVideoSlider,
        'upload' => $upload,
        'fid' => NULL,
        'dataField' => NULL,
        'dataEntity' => NULL,
        'moduleCwh' => $moduleCwh,
        'scope' => $scope
    ]); ?>
</div>
