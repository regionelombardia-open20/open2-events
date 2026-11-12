<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\models\base
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

namespace open20\amos\events\models\base;

use open20\amos\core\record\Record;
use open20\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class AgidEventDocumentsMm
 *
 * This is the base-model class for table "agid_event_documents_mm".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $document_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \open20\amos\events\models\Event $event
 * @property \open20\amos\documenti\models\Documenti $document
 *
 * @package open20\amos\events\models\base
 */
abstract class AgidEventDocumentsMm extends Record
{
    /**
     * @var AmosEvents $eventsModule
     */
    public $eventsModule = null;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->eventsModule = AmosEvents::instance();
        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agid_event_documents_mm';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'document_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosEvents::t('amosevents', 'ID'),
            'event_id' => AmosEvents::t('amosevents', 'Event'),
            'document_id' => AmosEvents::t('amosevents', '#agid_document'),
            'created_at' => AmosEvents::t('amosevents', 'Creato il'),
            'updated_at' => AmosEvents::t('amosevents', 'Aggiornato il'),
            'deleted_at' => AmosEvents::t('amosevents', 'Cancellato il'),
            'created_by' => AmosEvents::t('amosevents', 'Creato da'),
            'updated_by' => AmosEvents::t('amosevents', 'Aggiornato da'),
            'deleted_by' => AmosEvents::t('amosevents', 'Cancellato da'),
        ]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne($this->eventsModule->model('Event'), ['id' => 'event_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        /** @var \open20\amos\documenti\AmosDocumenti $documentiModule */
        $documentiModule = \Yii::$app->getModule('documenti');
        if (is_null($documentiModule)) {
            return null;
        }
        return $this->hasOne($documentiModule->getModelClassName(), ['id' => 'document_id']);
    }
}
