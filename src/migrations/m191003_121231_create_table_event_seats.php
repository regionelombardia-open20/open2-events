<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\migrations
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

use open20\amos\core\migration\AmosMigrationTableCreation;

/**
 * Class m170315_121506_create_table_event_type
 */
class m191003_121231_create_table_event_seats extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%event_seats}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull()->comment('Event'),
            'sector' => $this->string()->notNull()->comment('Sector'),
            'row' => $this->string()->notNull()->comment('Row'),
            'seat' => $this->string()->notNull()->comment('Seat'),
            'status' => $this->integer()->defaultValue(1)->comment('Stato: 1-Empty,2-Assigned,3-To be assigned,4-Reassigned'),

            'type_of_assigned_participant' => $this->integer()->defaultValue(null)->comment('Type'),
            'user_id' => $this->integer()->defaultValue(null)->comment('User'),
            'event_participant_companion_id' => $this->integer()->defaultValue(null)->comment('Companion/Member of a group'),

            'automatic' => $this->integer(1)->defaultValue(0)->comment('Automatic'),
            'available_for_groups' => $this->integer(1)->defaultValue(0)->comment('Available forgroups'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function beforeTableCreation()
    {
        parent::beforeTableCreation();
        $this->setAddCreatedUpdatedFields(true);
    }

    /**
     * @inheritdoc
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey('fk_event_seats_event_id1', $this->getRawTableName(), 'event_id', '{{%event}}', 'id');
        $this->addForeignKey('fk_event_seats_user_id1', $this->getRawTableName(), 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_event_seats_companion_id1', $this->getRawTableName(), 'event_participant_companion_id', '{{%event_participant_companion}}', 'id');
    }
}
