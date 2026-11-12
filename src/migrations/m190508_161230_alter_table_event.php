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
 * Class m181106_150933_alter_table_event
 */
class m190508_161230_alter_table_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Event::tableName(), 'has_tickets', $this->boolean()->notNull()->defaultValue(0)->comment('Gestione biglietti?')->after('show_on_frontend'));
        $this->addColumn(Event::tableName(), 'has_qr_code', $this->boolean()->notNull()->defaultValue(0)->comment('Gestione QR code?')->after('has_tickets'));
        $this->addColumn(Event::tableName(), 'gdpr_question_1', $this->text()->null()->after('community_id'));
        $this->addColumn(Event::tableName(), 'gdpr_question_2', $this->text()->null()->after('gdpr_question_1'));
        $this->addColumn(Event::tableName(), 'gdpr_question_3', $this->text()->null()->after('gdpr_question_2'));
        $this->addColumn(Event::tableName(), 'gdpr_question_4', $this->text()->null()->after('gdpr_question_3'));
        $this->addColumn(Event::tableName(), 'gdpr_question_5', $this->text()->null()->after('gdpr_question_4'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Event::tableName(), 'has_tickets');
        $this->dropColumn(Event::tableName(), 'has_qr_code');
        $this->dropColumn(Event::tableName(), 'gdpr_question_1');
        $this->dropColumn(Event::tableName(), 'gdpr_question_2');
        $this->dropColumn(Event::tableName(), 'gdpr_question_3');
        $this->dropColumn(Event::tableName(), 'gdpr_question_4');
        $this->dropColumn(Event::tableName(), 'gdpr_question_5');
    }

}
