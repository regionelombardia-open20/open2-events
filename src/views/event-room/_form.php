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

use open20\amos\core\forms\ActiveForm;
use open20\amos\core\forms\CloseSaveButtonWidget;
use open20\amos\core\forms\CreatedUpdatedWidget;
use open20\amos\core\forms\RequiredFieldsTipWidget;
use open20\amos\events\AmosEvents;
use yii\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var \open20\amos\events\models\EventRoom $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="event-room-form">
    <?php
    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] // important
    ]);
    ?>

    <?php $this->beginBlock('general'); ?>
    <div class="row">
        <div class="col-lg-9 col-sm-9">
            <?= $form->field($model, 'room_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3 col-sm-3">
            <?= $form->field($model, 'available_seats')->textInput() ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php $this->endBlock(); ?>

    <?php
    $itemsTab[] = [
        'label' => AmosEvents::t('amosevents', 'General'),
        'content' => $this->blocks['general'],
    ];
    ?>

    <?= Tabs::widget([
        'encodeLabels' => false,
        'items' => $itemsTab
    ]); ?>

    <?= RequiredFieldsTipWidget::widget() ?>
    <?= CreatedUpdatedWidget::widget(['model' => $model]) ?>
    <?= CloseSaveButtonWidget::widget([
        'model' => $model
    ]); ?>
    <?php ActiveForm::end(); ?>
</div>
