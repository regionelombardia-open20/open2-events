<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\models
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

namespace open20\amos\events\models;

use open20\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class EventType
 * This is the model class for table "event_type".
 * @package open20\amos\events\models
 */
class EventType extends \open20\amos\events\models\base\EventType
{
    const TYPE_INFORMATIVE = 100; // Evento informativo
    const TYPE_OPEN = 101; // Evento con iscrizioni aperto
    const TYPE_UPON_INVITATION = 102; // Evento con iscrizioni su invito
    const TYPE_LIMITED_SEATS = 103; // Evento con posti limitati

    const ENABLED = 1;
    const DISABLED = 0;
    
    const ARRAYCSSCLASS = [
        self::TYPE_INFORMATIVE => 'event-infos',
        self::TYPE_OPEN => 'event-open',
        self::TYPE_UPON_INVITATION => 'event-on-invitation',
        self::TYPE_LIMITED_SEATS => 'event-limited-seat',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['event_type'], 'required'],
            [['limited_seats', 'manage_subscritions_queue', 'partners'], 'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'event_type' => AmosEvents::txt('#event_type'),
            'limited_seats' => AmosEvents::txt('#event_type_limited_seats'),
            'manage_subscritions_queue' => AmosEvents::txt('#event_type_manage_subscritions_queue'),
            'partners' => AmosEvents::txt('#event_type_partners'),
        ]);
    }

    /**
     * Gets options for radio buttons
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            self::TYPE_INFORMATIVE => AmosEvents::txt('#event_type_informative'),
            self::TYPE_OPEN => AmosEvents::txt('#event_type_open'),
            self::TYPE_UPON_INVITATION => AmosEvents::txt('#event_type_upon_invitation'),
        ];
    }
    
    /**
     * Gets text color based on background color
     * @return string
     */
    
    public static function colorText($color){
        if(empty($color)){
            return null;
        }
        $white="#FFFFFF";
        $black="#000000";
        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
        list($rw, $gw, $bw) = sscanf($white, "#%02x%02x%02x");
        list($rb, $gb, $bb) = sscanf($black, "#%02x%02x%02x");

        $difWhite=  max($r,$rw) - min($r,$rw) +
            max($g,$gw) - min($g,$gw) +
            max($b,$bw) - min($b,$bw);
        $difBlack=  max($r,$rb) - min($r,$rb) +
            max($g,$gb) - min($g,$gb) +
            max($b,$bb) - min($b,$bb);
        return $difWhite>$difBlack?$white:$black;
    }
}
