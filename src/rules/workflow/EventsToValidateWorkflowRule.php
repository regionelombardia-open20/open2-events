<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules\workflow
 * @category   CategoryName
 */

namespace lispa\amos\events\rules\workflow;

use lispa\amos\core\rules\ToValidateWorkflowContentRule;

class EventsToValidateWorkflowRule extends ToValidateWorkflowContentRule
{

    public $name = 'eventsToValidateWorkflow';
    public $validateRuleName = 'EventValidate';

}