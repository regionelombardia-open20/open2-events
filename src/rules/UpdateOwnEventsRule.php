<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
 */

namespace lispa\amos\events\rules;

use lispa\amos\core\rules\DefaultOwnContentRule;
use lispa\amos\events\models\Event;

/**
 * Class UpdateOwnEventsRule
 * @package lispa\amos\events\rules
 */
class UpdateOwnEventsRule extends DefaultOwnContentRule
{
    public $name = 'updateOwnEvents';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var Event $model */
            $model = $params['model'];

            if (!$model->id) {
                $post = \Yii::$app->getRequest()->post();
                $get = \Yii::$app->getRequest()->get();
                if (isset($get['id'])) {
                    $model = $this->instanceModel($model, $get['id']);
                } elseif (isset($post['id'])) {
                    $model = $this->instanceModel($model, $post['id']);
                }
            }
            if (!$model instanceof Event) {
                return false;
            }

            if (!empty($model->getWorkflowStatus())) {
                if (($model->getWorkflowStatus()->getId() == Event::EVENTS_WORKFLOW_STATUS_PUBLISHREQUEST ) && !(\Yii::$app->user->can('EventValidate', ['model' => $model]))) {
                    return false;
                }
            }
            return ($model->created_by == \Yii::$app->user->id);
        } else {
            return false;
        }
    }
}
