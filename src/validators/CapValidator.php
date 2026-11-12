<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos\events\validators
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

namespace open20\amos\events\validators;

use open20\amos\events\AmosEvents;
use yii\validators\Validator;

/**
 * Class CapValidator
 * @package open20\amos\events\validators
 */
class CapValidator extends Validator
{
    /**
     * @param \open20\amos\core\record\Record $model
     * @param string $attribute
     * @return boolean
     */
    function validateAttribute($model, $attribute)
    {
        $pi = $model->$attribute;
        if (strlen($pi) != 5) {
            $this->addError($model, $attribute, AmosEvents::t('amosevents', 'Not valid CAP. Length does not comply.'));
            return false;
        }
        if (!is_numeric($pi)) {
            $this->addError($model, $attribute, AmosEvents::t('amosevents', 'Not valid CAP. It presents non-numeric values.'));
            return false;
        }
        return true;
    }
}
