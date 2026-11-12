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

use open20\amos\core\migration\AmosMigrationTableCreation;

/**
 * Handles the creation of table `{{%event_invitation}}`.
 */
class m181112_163318_create_event_invitation_table extends AmosMigrationTableCreation
{
    
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%event_invitation}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'code' => $this->string(36)->null()->comment('UUID subsription code for external users'),
            'email' => $this->string(255),
            'fiscal_code' => $this->string(16),
            'name' => $this->string(16),
            'surname' => $this->string(16),
            'type' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('Type of invited user - 1:registered, 2:imported'),
            'state' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('State of invitation - 1:invited, 2:accepted, 3:rejected'),
            'invitation_sent_on' => $this->dateTime()->null(),
            'invitation_response_on' => $this->dateTime()->null(),
            'user_id' => $this->integer()->null(),
            'partner_of' => $this->integer()->null(),
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
        $this->addForeignKey('fk_event_invitation_event', $this->getRawTableName(), 'event_id', '{{%event}}', 'id');
        $this->addForeignKey('fk_event_invitation_user', $this->getRawTableName(), 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_event_invitation_partner', $this->getRawTableName(), 'partner_of', '{{%user}}', 'id');
    }

}
