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
 * Class m170315_121500_create_table_event_type_context
 */
class m170315_121500_create_table_event_type_context extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%event_type_context}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Title'),
            'description' => $this->text()->notNull()->comment('Description'),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function afterTableCreation()
    {
        $this->insert($this->tableName, ['id' => 1, 'title' => 'Generic (not defined)', 'description' => '"Not defined" for events of other type (meeting, activity, deadlines, workshop, conferences, etc)']);
        $this->insert($this->tableName, ['id' => 2, 'title' => 'Project', 'description' => '"Project" for event of a project']);
        $this->insert($this->tableName, ['id' => 3, 'title' => 'Matchmaking', 'description' => '"Matchmaking" for event of matchmaking']);
    }
}
