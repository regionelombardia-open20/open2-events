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

use open20\amos\events\models\EventType;
use yii\db\Migration;

/**
 * Class m181102_193402_alter_table_event_type
 */
class m181102_173402_alter_table_event_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(EventType::tableName(), 'event_context_id', $this->integer()->null()->defaultValue(null));
        $this->addColumn(EventType::tableName(), 'event_type', $this->integer(1)->null()->comment('Tipo di evento'));
        $this->addColumn(EventType::tableName(), 'limited_seats', $this->boolean()->notNull()->defaultValue(0)->comment('Posti limitati?'));
        $this->addColumn(EventType::tableName(), 'manage_subscritions_queue', $this->boolean()->notNull()->defaultValue(0)->comment('Gestione della coda di iscrizioni?'));
        $this->addColumn(EventType::tableName(), 'partners', $this->boolean()->notNull()->defaultValue(0)->comment('Iscrizione di accomapgnatori?'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(EventType::tableName(), 'event_type');
        $this->dropColumn(EventType::tableName(), 'limited_seats');
        $this->dropColumn(EventType::tableName(), 'manage_subscritions_queue');
        $this->dropColumn(EventType::tableName(), 'partners');
        $this->alterColumn(EventType::tableName(), 'event_context_id', $this->integer()->notNull());
    }

}
