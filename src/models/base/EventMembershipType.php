<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package lispa\amos\events\models\base
 * @category   CategoryName
 */

namespace lispa\amos\events\models\base;

use lispa\amos\events\AmosEvents;
use yii\helpers\ArrayHelper;

/**
 * Class EventMembershipType
 * This is the base-model class for table "event_membership_type".
 *
 * @property integer $id
 * @property string $title
 *
 * @property \lispa\amos\events\models\Event[] $events
 *
 * @package lispa\amos\events\models\base
 */
class EventMembershipType extends \lispa\amos\core\record\Record
{
    const TYPE_OPEN = 1;
    const TYPE_ON_INVITATION = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_membership_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => AmosEvents::t('amosevents', 'ID'),
            'title' => AmosEvents::t('amosevents', 'Title')
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(\lispa\amos\events\models\Event::className(), ['event_membership_type_id' => 'id']);
    }
}
