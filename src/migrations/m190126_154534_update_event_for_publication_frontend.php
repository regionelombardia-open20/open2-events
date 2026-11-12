<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\discussioni\migrations
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

use yii\db\Migration;

/**
 * Class m190126_154534_update_event_for_publication_frontend
 */
class m190126_154534_update_event_for_publication_frontend extends Migration
{
    const TABLE = '{{%event}}';

    public function safeUp()
    {
        $this->update(self::TABLE, ['primo_piano' => 1, 'in_evidenza' => 1],
            ['status' => open20\amos\events\models\Event::EVENTS_WORKFLOW_STATUS_PUBLISHED]);
        return true;
    }

    public function safeDown()
    {
        $this->update(self::TABLE, ['primo_piano' => 0, 'in_evidenza' => 0],
            ['status' => open20\amos\events\models\Event::EVENTS_WORKFLOW_STATUS_PUBLISHED]);
        return true;
    }
}
