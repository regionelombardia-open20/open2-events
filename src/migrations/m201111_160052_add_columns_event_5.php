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

use open20\amos\events\models\Event;
use yii\db\Migration;

/**
 * Class m201111_160052_add_columns_event_5
 */
class m201111_160052_add_columns_event_5 extends Migration
{
    private $tableName;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->tableName = Event::tableName();
    }
    
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'agid_event_typology_id', $this->smallInteger()->unsigned()->null()->defaultValue(null)->after('event_room_id'));
        $this->addColumn($this->tableName, 'agid_description', $this->string(255)->null()->defaultValue(null)->after('summary'));
        $this->addColumn($this->tableName, 'agid_georeferencing', $this->string(255)->null()->defaultValue(null)->after('agid_description'));
        $this->addColumn($this->tableName, 'agid_dates_and_hours', $this->text()->null()->defaultValue(null)->after('agid_georeferencing'));
        $this->addColumn($this->tableName, 'agid_price', $this->text()->null()->defaultValue(null)->after('agid_dates_and_hours'));
        $this->addColumn($this->tableName, 'agid_document_id', $this->integer()->null()->defaultValue(null)->after('agid_price'));
        $this->addColumn($this->tableName, 'agid_organized_by', $this->text()->null()->defaultValue(null)->after('agid_document_id'));
        $this->addColumn($this->tableName, 'agid_contact', $this->text()->null()->defaultValue(null)->after('agid_organized_by'));
        $this->addColumn($this->tableName, 'agid_website', $this->string(255)->null()->defaultValue(null)->after('agid_contact'));
        $this->addColumn($this->tableName, 'agid_other_informations', $this->text()->null()->defaultValue(null)->after('agid_website'));
        $this->addColumn($this->tableName, 'agid_geolocation', $this->string(255)->null()->defaultValue(null)->after('agid_other_informations'));
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'agid_event_typology_id');
        $this->dropColumn($this->tableName, 'agid_description');
        $this->dropColumn($this->tableName, 'agid_georeferencing');
        $this->dropColumn($this->tableName, 'agid_dates_and_hours');
        $this->dropColumn($this->tableName, 'agid_price');
        $this->dropColumn($this->tableName, 'agid_document_id');
        $this->dropColumn($this->tableName, 'agid_organized_by');
        $this->dropColumn($this->tableName, 'agid_contact');
        $this->dropColumn($this->tableName, 'agid_website');
        $this->dropColumn($this->tableName, 'agid_other_informations');
        return true;
    }
}
