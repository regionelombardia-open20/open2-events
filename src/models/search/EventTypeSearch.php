<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\models\search
 * @category   CategoryName
 */

namespace lispa\amos\events\models\search;

use lispa\amos\events\models\EventType;
use lispa\amos\events\models\EventTypeContext;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class EventTypeSearch
 * EventTypeSearch represents the model behind the search form about `lispa\amos\events\models\EventType`.
 * @package lispa\amos\events\models\search
 */
class EventTypeSearch extends EventType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'locationRequested', 'durationRequested', 'logoRequested', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['title', 'description', 'color', 'locationRequested', 'durationRequested', 'logoRequested', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EventType::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'title' => [
                    'asc' => [self::tableName() . '.title' => SORT_ASC],
                    'desc' => [self::tableName() . '.title' => SORT_DESC],
                ],
                'description' => [
                    'asc' => [self::tableName() . '.description' => SORT_ASC],
                    'desc' => [self::tableName() . '.description' => SORT_DESC],
                ],
                'color' => [
                    'asc' => [self::tableName() . '.color' => SORT_ASC],
                    'desc' => [self::tableName() . '.color' => SORT_DESC],
                ],
            ]]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', self::tableName() . '.description', $this->description])
            ->andFilterWhere([self::tableName() . '.color' => $this->color])
            ->andFilterWhere([self::tableName() . '.locationRequested' => $this->locationRequested])
            ->andFilterWhere([self::tableName() . '.durationRequested' => $this->durationRequested])
            ->andFilterWhere([self::tableName() . '.logoRequested' => $this->logoRequested]);

        return $dataProvider;
    }

    /**
     * This method search only the event types of generic context.
     * @return ActiveQuery
     */
    public static function searchGenericContextEventTypes()
    {
        return EventType::find()->andWhere(['event_context_id' => EventTypeContext::EVENT_TYPE_CONTEXT_GENERIC]);
    }

    /**
     * This method search only the event types of project context.
     * @return ActiveQuery
     */
    public static function searchProjectContextEventTypes()
    {
        return EventType::find()->andWhere(['event_context_id' => EventTypeContext::EVENT_TYPE_CONTEXT_PROJECT]);
    }

    /**
     * This method search only the event types of matchmaking context.
     * @return ActiveQuery
     */
    public static function searchMatchmakingContextEventTypes()
    {
        return EventType::find()->andWhere(['event_context_id' => EventTypeContext::EVENT_TYPE_CONTEXT_MATCHMAKING]);
    }
}
