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
use open20\amos\core\helpers\Html;
use open20\amos\core\forms\ActiveForm;
use kartik\datecontrol\DateControl;
use open20\amos\core\forms\Tabs;
use open20\amos\core\forms\CloseSaveButtonWidget;
use open20\amos\core\forms\RequiredFieldsTipWidget;
use yii\helpers\Url;
use open20\amos\core\forms\editors\Select;
use yii\helpers\ArrayHelper;
use open20\amos\core\icons\AmosIcons;
use yii\bootstrap\Modal;
use yii\redactor\widgets\Redactor;
use yii\helpers\Inflector;

/**
* @var yii\web\View $this
* @var open20\amos\events\models\EventCalendarsSlots $model
* @var yii\widgets\ActiveForm $form
*/

    $this->registerJs("
            $('#event-calendars-slots-date" . ((isset($fid))? $fid : 0) . "').change(function(){
        if($('#event-calendars-slots-date" . ((isset($fid))? $fid : 0) . "').val() == ''){
        $('#event-calendars-slots-date" . ((isset($fid))? $fid : 0) . "-disp-kvdate .input-group-addon.kv-date');
        } else {
        if($('#event-calendars-slots-date" . ((isset($fid))? $fid : 0) . "-disp-kvdate .input-group-addon.kv-date-remove').length == 0){
        $('#event-calendars-slots-date" . ((isset($fid))? $fid : 0) . "-disp-kvdate').append('<span class=\"input-group-addon kv-date-remove\" title=\"Pulisci campo\"><i class=\"glyphicon glyphicon-remove\"></i></span>');
        initDPRemove('event-calendars-slots-date" . ((isset($fid))? $fid : 0) . "-disp');
        }
        }
        });
        ", yii\web\View::POS_READY);

 ?>
<div class="event-calendars-slots-form col-xs-12 nop">

    <?php     $form = ActiveForm::begin([
    'options' => [
    'id' => 'event-calendars-slots_' . ((isset($fid))? $fid : 0),
    'data-fid' => (isset($fid))? $fid : 0,
    'data-field' => ((isset($dataField))? $dataField : ''),
    'data-entity' => ((isset($dataEntity))? $dataEntity : ''),
    'class' => ((isset($class))? $class : '')
    ]
    ]);
     ?>
    <?php // $form->errorSummary($model, ['class' => 'alert-danger alert fade in']); ?>
    
        <div class="row"><div class="col-xs-12"><h2 class="subtitle-form">Settings</h2><div class="col-md-8 col xs-12"><!-- event_calendars_id integer -->
			<?= $form->field($model, 'event_calendars_id')->textInput() ?><!-- date date -->
			<?= $form->field($model, 'date')->widget(DateControl::classname(), [
                           				'options' => [
                           				'id' => lcfirst(Inflector::id2camel(\yii\helpers\StringHelper::basename($model->className()), '_')) . '-date' . ((isset($fid))? $fid : 0),
                           				'layout' => '{input} {picker} ' . (($model->date == '')? '' : '{remove}')]
                        			]); ?><!-- hour_start time -->
			<?= $form->field($model, 'hour_start')->textInput() ?><!-- hour_end time -->
			<?= $form->field($model, 'hour_end')->textInput() ?>                        <?php 
                        if(\Yii::$app->getUser()->can('USER_CREATE')) {
                            $append = ' canInsert';
                        } else {
                            $append = NULL;
                        }
                        ?>
                        <?= $form->field($model, 'user_id')->widget(Select::classname(), [
                        'data' => ArrayHelper::map(\backend\modules\amosevents\models\User::find()->asArray()->all(),'id','username'),
                        'language' => substr(Yii::$app->language, 0, 2),
                        'options' => [
                            'id' => 'User0' . $fid,
                            'multiple' => false,
                            'placeholder' => 'Seleziona ...',
                            'class' => 'dynamicCreation' . $append,
                            'data-model' => 'user',
                            'data-field' => 'username',
                            'data-module' => 'amosevents',
                            'data-entity' => 'user',
                            'data-toggle' => 'tooltip'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'pluginEvents' => [
                            "select2:open" => "dynamicInsertOpening"
                        ]
                        ])->label('Utente') 
                        ?><?= RequiredFieldsTipWidget::widget(); ?><?= CloseSaveButtonWidget::widget(['model' => $model]); ?><?php ActiveForm::end(); ?></div><div class="col-md-4 col xs-12"></div></div><div class="clearfix"></div> 

</div>
</div>
