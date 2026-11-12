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

use open20\amos\events\helpers\google_api\Google_Service_Walletobjects_LocalizedString;
use \Google_Model;

class Google_Service_Walletobjects_TicketSeat extends Google_Model
{
    protected $internal_gapi_mappings = array(
    );
    public $coach;
    protected $customFareClassType = 'Google_Service_Walletobjects_LocalizedString';
    protected $customFareClassDataType = '';
    public $fareClass;
    public $seat;
    protected $seatAssignmentType = 'Google_Service_Walletobjects_LocalizedString';
    protected $seatAssignmentDataType = '';


    public function setCoach($coach)
    {
        $this->coach = $coach;
    }
    public function getCoach()
    {
        return $this->coach;
    }
    public function setCustomFareClass(Google_Service_Walletobjects_LocalizedString $customFareClass)
    {
        $this->customFareClass = $customFareClass;
    }
    public function getCustomFareClass()
    {
        return $this->customFareClass;
    }
    public function setFareClass($fareClass)
    {
        $this->fareClass = $fareClass;
    }
    public function getFareClass()
    {
        return $this->fareClass;
    }
    public function setSeat($seat)
    {
        $this->seat = $seat;
    }
    public function getSeat()
    {
        return $this->seat;
    }
    public function setSeatAssignment(Google_Service_Walletobjects_LocalizedString $seatAssignment)
    {
        $this->seatAssignment = $seatAssignment;
    }
    public function getSeatAssignment()
    {
        return $this->seatAssignment;
    }
}
