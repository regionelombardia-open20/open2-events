<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\models\base
 * @category   CategoryName
 */

namespace lispa\amos\events\models\base;

use lispa\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class EventType
 * This is the base-model class for table "event_type".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $color
 * @property integer $locationRequested
 * @property integer $durationRequested
 * @property integer $logoRequested
 * @property integer $event_context_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\events\models\EventTypeContext $eventTypeContext
 *
 * @package lispa\amos\events\models\base
 */
class EventType extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'color', 'event_context_id'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['locationRequested', 'durationRequested', 'logoRequested', 'event_context_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['title'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 2000],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosEvents::t('amosevents', 'ID'),
            'title' => AmosEvents::t('amosevents', 'Title'),
            'description' => AmosEvents::t('amosevents', 'Description'),
            'color' => AmosEvents::t('amosevents', 'Color'),
            'locationRequested' => AmosEvents::t('amosevents', 'Location Requested'),
            'durationRequested' => AmosEvents::t('amosevents', 'Duration Requested'),
            'logoRequested' => AmosEvents::t('amosevents', 'Logo Requested'),
            'event_context_id' => AmosEvents::t('amosevents', 'Event Context ID'),
            'created_at' => AmosEvents::t('amosevents', 'Created At'),
            'updated_at' => AmosEvents::t('amosevents', 'Updated At'),
            'deleted_at' => AmosEvents::t('amosevents', 'Deleted At'),
            'created_by' => AmosEvents::t('amosevents', 'Created By'),
            'updated_by' => AmosEvents::t('amosevents', 'Updated By'),
            'deleted_by' => AmosEvents::t('amosevents', 'Deleted By')
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventTypeContext()
    {
        return $this->hasOne(\lispa\amos\events\models\EventTypeContext::className(), ['id' => 'event_context_id']);
    }
}
