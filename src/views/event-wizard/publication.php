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

use open20\amos\core\forms\ActiveForm;
use open20\amos\events\AmosEvents;
use open20\amos\core\forms\WizardPrevAndContinueButtonWidget;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var ActiveForm $form
 * @var \open20\amos\events\models\Event $model
 */

$moduleCwh = Yii::$app->getModule('cwh');
$moduleTag = Yii::$app->getModule('tag');

$this->title = AmosEvents::t('amosevents',"Nuovo Evento");

?>

<div class="event-wizard-publication">
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'event-wizard-form',
            'class' => 'form',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]
    ]); ?>

    <?php
    $moduleNews = \Yii::$app->getModule(AmosEvents::getModuleName());
    if($moduleNews->hidePubblicationDate == false){?>
    <section>
        <div class="row">
            <div class="col-lg-4 col-sm-4">
                <?= $form->field($model, 'publication_date_begin')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                ]); ?>
            </div>
            <div class="col-lg-4 col-sm-4">
                <?= $form->field($model, 'publication_date_end')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                ]); ?>
            </div>
        </div>
    </section>
    <?php } ?>
    <section>
        <div class="row">
            <?php if (isset($moduleCwh) && in_array(get_class($model), $moduleCwh->modelsEnabled)): ?>
                <?= \Yii::$app->controller->renderFile('@vendor/open20/amos-cwh/src/views/pubblicazione/cwh.php',
                    [
                        'model' => $model,
                        'form' => $form

                    ]); ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php if (isset($moduleTag) && in_array(get_class($model), $moduleTag->modelsEnabled) && $moduleTag->behaviors): ?>
                <?= \open20\amos\tag\widgets\TagWidget::widget([
                    'model' => $model,
                    'attribute' => 'tagValues',
                    'form' => \yii\base\Widget::$stack[0]
                ]); ?>
            <?php endif; ?>
        </div>
    </section>

    <?= WizardPrevAndContinueButtonWidget::widget([
        'model' => $model,
        'previousUrl' => Yii::$app->getUrlManager()->createUrl(['/events/event-wizard/organizational-data', 'id' => $model->id]),
        'continueLabel' => AmosEvents::tHtml('amosevents', 'Finish and save'),
        'continueOptions' => [
            'data-confirm' => AmosEvents::t('amosevents', 'You are finishing the event creation and you cannot go back. Do you want to continue?')
        ],
        'cancelUrl' => Yii::$app->session->get(AmosEvents::beginCreateNewSessionKey())
    ]) ?>
    <?php ActiveForm::end(); ?>
</div>
