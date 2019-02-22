<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\event-type
 * @category   CategoryName
 */

use lispa\amos\core\forms\CloseButtonWidget;
use lispa\amos\events\AmosEvents;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\events\models\EventType $model
 */

$this->title = strip_tags($model->title);
$this->params['breadcrumbs'][] = ['label' => AmosEvents::t('amosevents', 'Event Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-type-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:html',
            'color',
            [
                'label' => AmosEvents::t('amosevents', 'Event context'),
                'value' => function ($model) {
                    /** @var \lispa\amos\events\models\EventType $model */
                    return AmosEvents::t('amosevents', $model->eventTypeContext->title);
                }
            ],
        ],
    ]) ?>
</div>

<?= CloseButtonWidget::widget([
    'title' => AmosEvents::t('amosevents', 'Close'),
    'layoutClass' => 'pull-right'
]) ?>
