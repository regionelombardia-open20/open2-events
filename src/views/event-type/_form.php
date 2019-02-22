<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\event-type
 * @category   CategoryName
 */

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\Tabs;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\EventTypeContext;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\redactor\widgets\Redactor;

/**
 * @var yii\web\View $this
 * @var lispa\amos\events\models\EventType $model
 * @var yii\widgets\ActiveForm $form
 * @var string $fid
 */

?>

<div class="event-type-form col-xs-12 nop">
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'event-type_' . ((isset($fid)) ? $fid : 0),
            'data-fid' => (isset($fid)) ? $fid : 0,
            'data-field' => ((isset($dataField)) ? $dataField : ''),
            'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
            'class' => ((isset($class)) ? $class : '')
        ]
    ]);
    ?>
    <?php // $form->errorSummary($model, ['class' => 'alert-danger alert fade in']); ?>
    <?php $this->beginBlock('general'); ?>
    <div class="row">
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'color')->widget(\kartik\color\ColorInput::className(), [
                'options' => ['placeholder' => AmosEvents::t('amosevents', 'Select/choose color') . '...'],
                'pluginOptions' => ['appendTo' => '#event-type_' . ((isset($fid)) ? $fid : 0)],
            ]) ?>
        </div>
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'event_context_id')->widget(Select2::className(), [
                'options' => ['placeholder' => AmosEvents::t('amosevents', 'Select/choose event context'), 'disabled' => false],
                'data' => ArrayHelper::map(EventTypeContext::find()->orderBy('id')->all(), 'id', 'title')
            ])->label(AmosEvents::t('amosevents', 'Event context')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <?= $form->field($model, 'description')->widget(Redactor::className(), [
                'clientOptions' => [
                    'buttonsHide' => [
                        'image',
                        'file'
                    ],
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'locationRequested')->checkbox() ?>
        </div>
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'durationRequested')->checkbox() ?>
        </div>
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'logoRequested')->checkbox() ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php $this->endBlock(); ?>
    
    <?php $itemsTab[] = [
        'label' => AmosEvents::tHtml('amosevents', 'General'),
        'content' => $this->blocks['general'],
    ];
    ?>
    
    <?= Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]
    );
    ?>
    <?= CreatedUpdatedWidget::widget(['model' => $model]) ?>
    <?= CloseSaveButtonWidget::widget(['model' => $model]); ?>
    <?php ActiveForm::end(); ?>
</div>
