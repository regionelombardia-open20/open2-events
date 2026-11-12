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
 * Class m190523_114131_create_table_event_participant_companion
 */
class m190523_114131_create_table_event_participant_companion extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%event_participant_companion}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull()->comment('Nome accompagnatore'),
            'cognome' => $this->string()->notNull()->comment('Cognome accompagnatore'),
            'email' => $this->string()->notNull()->comment('Email accompagnatore'),
            'codice_fiscale' => $this->string(30)->comment('Email accompagnatore'),
            'azienda' => $this->string()->comment('Azienda accompagnatore'),
            'note' => $this->text()->comment('Note'),
            'presenza' => $this->boolean()->notNull()->defaultValue(0)->comment('Presenza all\'evento'),
            'event_invitation_id' => $this->integer()->notNull()->comment('FK ID utente accompagnato (associato all\'invito)'),
            'event_accreditation_list_id' => $this->integer()->comment('FK ID lista accreditamento'),
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
        $this->addForeignKey('fk_event_participant_companion_event_invitation_id', $this->getRawTableName(), 'event_invitation_id', '{{%event_invitation}}', 'id');
        $this->addForeignKey('fk_event_participant_companion_event_accreditation_list_id', $this->getRawTableName(), 'event_accreditation_list_id', '{{%event_accreditation_list}}', 'id');
    }
}
