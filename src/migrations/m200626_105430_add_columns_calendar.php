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
 * Class m200203_181730_add_columns_event_1
 */
class m200626_105430_add_columns_calendar extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_calendars', 'record_id', $this->integer()->comment('Record')->after('slot_duration'));
        $this->addColumn('event_calendars', 'classname', $this->string()->comment('Classname')->after('slot_duration'));
        $this->addColumn('event_calendars', 'max_participant', $this->integer()->comment('Max Participant')->after('slot_duration'));
        $this->addColumn('event_calendars', 'break_time', $this->integer()->comment('Break time (minute)')->after('slot_duration'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_calendars', 'record_id');
        $this->dropColumn('event_calendars', 'classname');
        $this->dropColumn('event_calendars', 'break_time');
        $this->dropColumn('event_calendars', 'max_participant');

    }
}