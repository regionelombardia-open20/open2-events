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
 * Class EventTypeContext
 * This is the base-model class for table "event_type_context".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * @property \lispa\amos\events\models\EventType[] $eventTypes
 *
 * @package lispa\amos\events\models\base
 */
class EventTypeContext extends \lispa\amos\core\record\Record
{
    const EVENT_TYPE_CONTEXT_GENERIC = 1;
    const EVENT_TYPE_CONTEXT_PROJECT = 2;
    const EVENT_TYPE_CONTEXT_MATCHMAKING = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_type_context';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2000],
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
            'description' => AmosEvents::t('amosevents', 'Description')
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventTypes()
    {
        return $this->hasMany(\lispa\amos\events\models\EventType::className(), ['id' => 'event_context_id']);
    }
}
