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
class m220307_143505_change_default_event_types_info extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        {
        $this->update(EventType::tableName(), 
                ['color' => '#5c6f82','type_icon'=> 'seat'],
                ['event_type' => EventType::TYPE_INFORMATIVE]);
        
        $this->update(EventType::tableName(), 
                ['color' => '#008758','type_icon'=> 'info-outline'],
                ['event_type' => EventType::TYPE_OPEN]);
        
        $this->update(EventType::tableName(), 
                ['color' => '#a66300','type_icon'=> 'account-box-mail'],
                ['event_type' => EventType::TYPE_UPON_INVITATION]);
        
        $this->update(EventType::tableName(), 
                ['color' => '#A61919','type_icon'=> 'ticket-star'],
                ['event_type' => EventType::TYPE_LIMITED_SEATS]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(EventType::tableName(), 
                ['color' => '#000000','type_icon'=> 'seat'],
                ['event_type' => EventType::TYPE_INFORMATIVE]);
        
        $this->update(EventType::tableName(), 
                ['color' => '#000000','type_icon'=> 'seat'],
                ['event_type' => EventType::TYPE_OPEN]);
        
        $this->update(EventType::tableName(), 
                ['color' => '#000000','type_icon'=> 'seat'],
                ['event_type' => EventType::TYPE_UPON_INVITATION]);
        
        $this->update(EventType::tableName(), 
                ['color' => '#000000','type_icon'=> 'seat'],
                ['event_type' => EventType::TYPE_LIMITED_SEATS]);
    }
}
