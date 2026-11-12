<?php
/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-events
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

namespace open20\amos\events\helpers\google_api;

use open20\amos\events\helpers\google_api\Google_Service_Walletobjects_FieldSelector;
use \Google_Model;

class Google_Service_Walletobjects_TemplateItem extends Google_Model
{
    protected $internal_gapi_mappings = array(
    );
    protected $firstValueType = 'Google_Service_Walletobjects_FieldSelector';
    protected $firstValueDataType = '';
    public $predefinedItem;
    protected $secondValueType = 'Google_Service_Walletobjects_FieldSelector';
    protected $secondValueDataType = '';


    public function setFirstValue(Google_Service_Walletobjects_FieldSelector $firstValue)
    {
        $this->firstValue = $firstValue;
    }
    public function getFirstValue()
    {
        return $this->firstValue;
    }
    public function setPredefinedItem($predefinedItem)
    {
        $this->predefinedItem = $predefinedItem;
    }
    public function getPredefinedItem()
    {
        return $this->predefinedItem;
    }
    public function setSecondValue(Google_Service_Walletobjects_FieldSelector $secondValue)
    {
        $this->secondValue = $secondValue;
    }
    public function getSecondValue()
    {
        return $this->secondValue;
    }
}
