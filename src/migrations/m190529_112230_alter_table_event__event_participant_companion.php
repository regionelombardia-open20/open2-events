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
use open20\amos\events\models\EventParticipantCompanion;
use yii\db\Migration;

/**
 * Class m190529_112230_alter_table_event__event_participant_companion
 */
class m190529_112230_alter_table_event__event_participant_companion extends Migration
{
    private 
        $tableEventName,
        $tableEventParticipantCompanionName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->tableEventName = Event::tableName();
        $this->tableEventParticipantCompanionName = EventParticipantCompanion::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = \Yii::$app->db->schema->getTableSchema($this->tableEventName);
        if (!isset($table->columns['email_subscribe_view'])) {
            $this->addColumn($this->tableEventName, 'email_subscribe_view', $this->string(400)->null()->comment('Event confirm mail layout')->after('ticket_layout_view'));
        }
        
        $table = \Yii::$app->db->schema->getTableSchema($this->tableEventParticipantCompanionName);
        if (!isset($table->columns['user_id'])) {
            $this->addColumn($this->tableEventParticipantCompanionName, 'user_id', $this->integer()->null()->comment('FK user id')->after('event_accreditation_list_id'));
            $this->addForeignKey('event_participant_companion_user_id_fk', $this->tableEventParticipantCompanionName, 'user_id', 'user', 'id', 'NO ACTION', 'NO ACTION');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Event::tableName(), 'email_subscribe_view');
        $this->dropColumn(EventParticipantCompanion::tableName(), 'user_id');
        $this->dropForeignKey(EventParticipantCompanion::tableName(), 'event_participant_companion_user_id_fk');
    }

}
