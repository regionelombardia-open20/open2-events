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

use \Google_Model;
use open20\amos\events\helpers\google_api\Google_Service_Walletobjects_LocalizedString;

class Google_Service_Walletobjects_EventVenue extends Google_Model
{
    protected $internal_gapi_mappings = array(
    );
    protected $addressType = 'Google_Service_Walletobjects_LocalizedString';
    protected $addressDataType = '';
    public $kind;
    protected $nameType = 'Google_Service_Walletobjects_LocalizedString';
    protected $nameDataType = '';


    public function setAddress(Google_Service_Walletobjects_LocalizedString $address)
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setName(Google_Service_Walletobjects_LocalizedString $name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
}
