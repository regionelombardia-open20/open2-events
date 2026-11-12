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

use open20\amos\events\AmosEvents;
use open20\amos\events\models\Event;
use open20\amos\seo\models\SeoData;
use yii\db\Migration;

/**
 * Class m181220_110043_populate_seo_data_events */
class m181220_110043_populate_seo_data_events extends Migration {

    public function safeUp() {
        $eventtotsave = 0;
        $eventtotnotsave = 0;
        try {
            /** @var Event $eventModel */
            $eventModel = AmosEvents::instance()->createModel('Event');
            foreach ($eventModel::find()
                    ->orderBy(['id' => SORT_ASC])
                    ->all() as $event) {
                /** @var Event $event */

                $seoData = SeoData::findOne([
                            'classname' => $event->className(),
                            'content_id' => $event->id
                ]);

                if (is_null($seoData)) {
                    $seoData = new SeoData();
                    $pars = [];
                    $pars = ['pretty_url' => $event->title,
                        'meta_title' => '',
                        'meta_description' => '',
                        'meta_keywords' => '',
                        'og_title' => '',
                        'og_description' => '',
                        'og_type' => '',
                        'unavailable_after_date' => '',
                        'meta_robots' => '',
                        'meta_googlebot' => ''];
                    $seoData->aggiornaSeoData($event, $pars);
                    $eventtotsave++;
                } else {
                    $eventtotnotsave++;
                }
            }
            \yii\helpers\Console::stdout("Records Seo_data News save: $eventtotsave\n\n");
            \yii\helpers\Console::stdout("Records Seo_data News already present: $eventtotnotsave\n\n");
        } catch (Exception $ex) {
            \yii\helpers\Console::stdout("Error transaction News " . $ex->getMessage());
        }
        return true;
    }

    public function safeDown() {
        $eventtotdel = 0;
        try {
            /** @var Event $eventModel */
            $eventModel = AmosEvents::instance()->createModel('Event');
            foreach ($eventModel::find()
                    ->orderBy(['id' => SORT_ASC])
                    ->all() as $event) {
                /** @var Event $event */

                $where = " classname LIKE '" . addslashes(addslashes($event->className())) . "' AND content_id = " . $event->id;
                $this->delete(SeoData::tableName(), $where);

                $eventtotdel++;
            }
            \yii\helpers\Console::stdout("Records Seo_data delete: $eventtotdel\n\n");
        } catch (Exception $ex) {
            \yii\helpers\Console::stdout("Module Seo not configured " . $ex->getMessage());
        }
        return true;           
    }
}
