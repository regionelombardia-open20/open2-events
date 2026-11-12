<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\models\base
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

namespace open20\amos\events\models\base;

use open20\amos\core\record\Record;
use open20\amos\core\validators\CFValidator;
use open20\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class EventParticipantCompanion
 *
 * This is the base-model class for table "event_participant_companion".
 *
 * @property integer $id
 * @property string $nome
 * @property string $cognome
 * @property string $email
 * @property string $codice_fiscale
 * @property string $azienda
 * @property string $note
 * @property integer $presenza
 * @property string $presenza_scansionata_il
 * @property integer $event_invitation_id
 * @property integer $event_accreditation_list_id
 * @property integer $user_id
 *
 * @property \open20\amos\core\user\User $user
 * @property \open20\amos\events\models\EventAccreditationList $accreditationList
 * @property \open20\amos\events\models\EventSeats $assignedSeat
 *
 * @package open20\amos\events\models
 */
abstract class EventParticipantCompanion extends Record
{
    /**
     * @var AmosEvents $eventsModule
     */
    public $eventsModule = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_participant_companion';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->eventsModule = AmosEvents::instance();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [[
                'azienda',
                'note',
            ], 'string'],
            [[
                'nome',
                'cognome',
                'azienda',
                'note',
            ], 'safe'],
            [[
                'presenza',
                'user_id'
            ], 'integer'],
            [[
                'event_invitation_id',
                'event_accreditation_id',
                'presenza_scansionata_il',
                'user_id',
            ], 'safe'],
            ['email', 'email'],
            ['codice_fiscale', CFValidator::className()],
            [[
                'nome',
                'cognome',
                'email'
            ], 'required'],
        ];

        $eventTmp = $this->getEvent();
        if (!empty($eventTmp) && $eventTmp->abilita_codice_fiscale_in_form) {
            $rules[] = [
                ['codice_fiscale'], 'required'
            ];
        }

        return ArrayHelper::merge(
            parent::rules(), $rules
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'nome' => AmosEvents::t('amosevents', 'Nome'),
            'cognome' => AmosEvents::t('amosevents', 'Cognome'),
            'email' => AmosEvents::t('amosevents', 'Email'),
            'codice_fiscale' => AmosEvents::t('amosevents', 'Codice Fiscale'),
            'azienda' => AmosEvents::t('amosevents', 'Azienda'),
            'note' => AmosEvents::t('amosevents', 'Note'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\open20\amos\core\user\User::className(), ['id' => 'user_id']);
    }

    public function getAccreditationList()
    {
        return $this->hasOne($this->eventsModule->model('EventAccreditationList'), ['id' => 'event_accreditation_list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedSeat()
    {
        return $this->hasOne($this->eventsModule->model('EventSeats'), ['event_participant_companion_id' => 'id']);
    }
}
