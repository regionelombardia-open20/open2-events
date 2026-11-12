<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\widgets
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

namespace open20\amos\events\widgets;

use yii\base\Widget;

/**
 * Class EventsPublishedByWidget
 * Shows the entities name publishing the content and the selected publication rule
 * @package open20\amos\events\widgets
 */
class EventsPublishedByWidget extends Widget
{
    /**
     * @var string $layout The layout view
     */
    public $layout = '@vendor/open20/amos-events/src/views/event-wizard/layouts/event_published_by_widget.php';

    /**
     * @var array $entities The list of entities publishing a specific content (news, topic, etc)
     */
    public $entities;

    /**
     * @var integer $publicationRule The id of the publication rule for the specific content
     */
    public $publicationRule;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $i = 0;
        $publishingEntities = '-';
        $recipients = '-';
        if (!is_null($this->entities) && (count($this->entities) > 0)) {
            $publishingEntities = '';
            $moduleCwh = \Yii::$app->getModule('cwh');
            foreach ($this->entities as $publishingEntity) {
                if (isset($moduleCwh)) {
                    $entity = \open20\amos\cwh\models\CwhNodi::findOne($publishingEntity);
                }
                
                if ($i > 0) {
                    $publishingEntities .= ', ';
                }
                
                if (!empty($entity)) {
                    $publishingEntities .= $entity->text;
                }
                
                $i++;
            }
        }
        
        if (!is_null($this->publicationRule)) {
            $pubblicationRule = \open20\amos\cwh\models\base\CwhRegolePubblicazione::findOne($this->publicationRule);
            $recipients = (!is_null($pubblicationRule) ? $pubblicationRule->nome : '-');
        }
        
        return $this->renderFile(
            $this->layout,
            [
                'publishingEntities' => $publishingEntities,
                'recipients' => $recipients
            ]
        );
    }
}
