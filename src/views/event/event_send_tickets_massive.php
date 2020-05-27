<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\events\views\event
 * @category   CategoryName
 */

use open20\amos\core\forms\ActiveForm;
use open20\amos\core\helpers\Html;
use open20\amos\events\AmosEvents;
use open20\amos\events\models\EventSeats;
use kartik\grid\GridView;
use yii\db\ActiveQuery;

/**
 * @var array $currentView
 * @var ActiveQuery $invitations
 * @var \open20\amos\events\models\Event $event
 * @var array|string $previousUrl
 */

$this->title = AmosEvents::t('amosevents', 'Send tickets');
$this->params['breadcrumbs'][] = ['label' => Yii::$app->session->get('previousTitle'), 'url' => Yii::$app->session->get('previousUrl')];
$this->params['breadcrumbs'][] = $this->title;
$seatManagementEnabled = $event->seats_management;

/** @var AmosEvents $eventsModule */
$eventsModule = AmosEvents::instance();
/** @var EventSeats $eventSeatsModel */
$eventSeatsModel = $eventsModule->createModel('EventSeats');

?>

    <p>
        <?= AmosEvents::txt('Seleziona a chi inviare i ticket dalla lista che trovi di seguito.'); ?>
        <br/>
        <?= AmosEvents::txt('I partecipanti a cui non sono ancora stati inviati i biglietti sono selezionati automaticamente.'); ?>
        <br/><br/>
        <?= AmosEvents::txt('Nella lista riportata di seguito sono mostrati solamente i partecipanti che hanno ricevuto una lista di accreditamento per se e per i propri accompagnatori. Per mostrare altri nominativi nella lista, assegnare liste di accreditamento a tutti i partecipanti e accompagnatori iscritti.'); ?>
        <br/><br/>
        <?= AmosEvents::txt('Al termine, clicca sul pulsante') . ' ' . AmosEvents::txt('conferma invio biglietti') . '.'; ?>
    </p>
    <br/>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'event_send_tickets_massive_' . ((isset($event->id)) ? $event->id : 0),
        'data-fid' => (isset($event->id)) ? $event->id : 0,
        'data-field' => ((isset($dataField)) ? $dataField : ''),
        'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
        'class' => ((isset($class)) ? $class : ''),
        'enctype' => 'multipart/form-data' // important
    ]
]);
?>
<?=
GridView::widget([
    'defaultPagination' => 'all',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $invitations
    ]),
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => '-'
    ],
    'responsive' => true,
    'export' => false,
    'columns' => [
        'name',
        'surname',
        'company',
        'email',
        [
            'value' => function ($model) use ($event, $eventSeatsModel) {
                $seats = $eventSeatsModel::find()
                    ->andWhere(['event_id' => $event->id])
                    ->andWhere(['user_id' => $model->user_id])->one();
                if ($seats) {
                    return $seats->getStringCoordinateSeat();
                }
                return '-';
            },
            'label' => AmosEvents::t('amosevents', 'Posto assegnato'),
            'visible' => $seatManagementEnabled
        ],
        [
            'label' => AmosEvents::txt('Accreditation list'),
            'value' => 'accreditationList.title',
        ],
        [
            'label' => AmosEvents::txt('Tickets sent?'),
            'value' => function ($model) {
                return $model->is_ticket_sent ? Yii::t('amoscore', 'Yes') : Yii::t('amoscore', 'No');
            }
        ],
        [
            'class' => 'yii\grid\CheckboxColumn',
            'name' => 'selectedInvitations',
            'checkboxOptions' => function ($model) {
                return [
                    'value' => $model->id,
                    'checked' => !$model->is_ticket_sent,
                ];
            },
        ],
    ]
]);
?>

    <div class="row">
        <div class="col-xs-2">
            <?=
            \yii\helpers\Html::a(
                \Yii::t('amoscore', 'Annulla'),
                $previousUrl,
                [
                    'class' => 'btn btn-secondary'
                ]
            );
            ?>
        </div>
        <div class="col-xs-10">
            <?= Html::submitButton(AmosEvents::txt('conferma invio biglietti'), ['class' => 'btn btn-primary pull-right']) ?>
        </div>
    </div>

<?php
ActiveForm::end();
?>