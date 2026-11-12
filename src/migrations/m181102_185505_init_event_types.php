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

use open20\amos\events\models\EventType;
use yii\db\Migration;

/**
 * Class m181102_185505_init_event_types
 */
class m181102_185505_init_event_types extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert(EventType::tableName(), [
            'id' => 100,
            'title' => 'Evento informativo',
            'description' => 'Evento informativo',
            'color' => '#ffffff',
            'event_type' => EventType::TYPE_INFORMATIVE,
        ]);
        $this->insert(EventType::tableName(), [
            'id' => 101,
            'title' => 'Evento aperto',
            'description' => 'Evento aperto',
            'color' => '#ffffff',
            'event_type' => EventType::TYPE_OPEN,
            'partners' => 1,
        ]);
        $this->insert(EventType::tableName(), [
            'id' => 102,
            'title' => 'Evento su invito',
            'description' => 'Evento su invito',
            'color' => '#ffffff',
            'event_type' => EventType::TYPE_UPON_INVITATION,
            'partners' => 1,
        ]);
        $this->insert(EventType::tableName(), [
            'id' => 103,
            'title' => 'Evento a posti limitati',
            'description' => 'Evento a posti limitati',
            'color' => '#ffffff',
            'event_type' => EventType::TYPE_UPON_INVITATION,
            'limited_seats' => 1,
            'manage_subscritions_queue' => 1,
            'partners' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(EventType::tableName(), 'id IN (100, 101, 102, 103)');
    }
}
