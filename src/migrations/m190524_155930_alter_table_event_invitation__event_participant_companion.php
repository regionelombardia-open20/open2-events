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

use open20\amos\events\models\Event;
use open20\amos\events\models\EventInvitation;
use open20\amos\events\models\EventParticipantCompanion;
use yii\db\Migration;

/**
 * Class m190524_155930_alter_table_event_invitation__event_participant_companion
 */
class m190524_155930_alter_table_event_invitation__event_participant_companion extends Migration
{
    private 
        $tableEventInvitationName,
        $tableEventParticipantCompanionName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->tableEventInvitationName = EventInvitation::tableName();
        $this->tableEventParticipantCompanionName = EventParticipantCompanion::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $table = \Yii::$app->db->schema->getTableSchema($this->tableEventInvitationName);
        if (!isset($table->columns['presenza_scansionata_il'])) {
            $this->addColumn($this->tableEventInvitationName, 'presenza_scansionata_il', $this->dateTime()->null()->comment('Presenza scansionata il')->after('presenza'));
        }
        
        $table = \Yii::$app->db->schema->getTableSchema($this->tableEventParticipantCompanionName);
        if (!isset($table->columns['presenza_scansionata_il'])) {
            $this->addColumn($this->tableEventParticipantCompanionName, 'presenza_scansionata_il', $this->dateTime()->null()->comment('Presenza scansionata il')->after('presenza'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\open20\amos\events\models\EventInvitation::tableName(), 'presenza_scansionata_il');
        $this->dropColumn(\open20\amos\events\models\EventParticipantCompanion::tableName(), 'presenza_scansionata_il');
    }

}
