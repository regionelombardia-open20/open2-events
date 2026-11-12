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
use yii\db\Migration;

/**
 * Class m190524_173430_alter_table_event
 */
class m200129_121730_add_columns_event_calendars extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_calendars', 'partner_user_id', $this->integer()->comment('Partner')->after('description'));
        $this->addColumn('event_calendars', 'group', $this->string()->comment('Group')->after('description'));
        $this->addColumn('event_calendars', 'ecosystem', $this->string()->comment('Ecosystem')->after('description'));
        $this->addColumn('event_calendars', 'short_description', $this->text()->comment('Short description')->after('description'));
        
        $this->addForeignKey('fk_event_calendars_partner_user_id1', 'event_calendars', 'partner_user_id', 'user', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        $this->dropForeignKey('fk_event_calendars_partner_user_id1', 'event_calendars');
        $this->dropColumn('event_calendars', 'partner_user_id');
        $this->dropColumn('event_calendars', 'group');
        $this->dropColumn('event_calendars', 'ecosystem');
        $this->dropColumn('event_calendars', 'short_description');
        $this->execute('SET FOREIGN_KEY_CHECKS=1');

    }

}
