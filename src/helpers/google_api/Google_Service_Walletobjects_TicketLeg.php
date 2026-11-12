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

class Google_Service_Walletobjects_TicketLeg extends \Google_Collection
{
    protected $collection_key = 'ticketSeats';
    protected $internal_gapi_mappings = array(
    );
    public $arrivalDateTime;
    public $carriage;
    public $departureDateTime;
    protected $destinationNameType = 'Google_Service_Walletobjects_LocalizedString';
    protected $destinationNameDataType = '';
    public $destinationStationCode;
    protected $fareNameType = 'Google_Service_Walletobjects_LocalizedString';
    protected $fareNameDataType = '';
    protected $originNameType = 'Google_Service_Walletobjects_LocalizedString';
    protected $originNameDataType = '';
    public $originStationCode;
    public $platform;
    protected $ticketSeatType = 'Google_Service_Walletobjects_TicketSeat';
    protected $ticketSeatDataType = '';
    protected $ticketSeatsType = 'Google_Service_Walletobjects_TicketSeat';
    protected $ticketSeatsDataType = 'array';
    protected $transitOperatorNameType = 'Google_Service_Walletobjects_LocalizedString';
    protected $transitOperatorNameDataType = '';
    protected $transitTerminusNameType = 'Google_Service_Walletobjects_LocalizedString';
    protected $transitTerminusNameDataType = '';
    public $zone;


    public function setArrivalDateTime($arrivalDateTime)
    {
        $this->arrivalDateTime = $arrivalDateTime;
    }
    public function getArrivalDateTime()
    {
        return $this->arrivalDateTime;
    }
    public function setCarriage($carriage)
    {
        $this->carriage = $carriage;
    }
    public function getCarriage()
    {
        return $this->carriage;
    }
    public function setDepartureDateTime($departureDateTime)
    {
        $this->departureDateTime = $departureDateTime;
    }
    public function getDepartureDateTime()
    {
        return $this->departureDateTime;
    }
    public function setDestinationName(Google_Service_Walletobjects_LocalizedString $destinationName)
    {
        $this->destinationName = $destinationName;
    }
    public function getDestinationName()
    {
        return $this->destinationName;
    }
    public function setDestinationStationCode($destinationStationCode)
    {
        $this->destinationStationCode = $destinationStationCode;
    }
    public function getDestinationStationCode()
    {
        return $this->destinationStationCode;
    }
    public function setFareName(Google_Service_Walletobjects_LocalizedString $fareName)
    {
        $this->fareName = $fareName;
    }
    public function getFareName()
    {
        return $this->fareName;
    }
    public function setOriginName(Google_Service_Walletobjects_LocalizedString $originName)
    {
        $this->originName = $originName;
    }
    public function getOriginName()
    {
        return $this->originName;
    }
    public function setOriginStationCode($originStationCode)
    {
        $this->originStationCode = $originStationCode;
    }
    public function getOriginStationCode()
    {
        return $this->originStationCode;
    }
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }
    public function getPlatform()
    {
        return $this->platform;
    }
    public function setTicketSeat(Google_Service_Walletobjects_TicketSeat $ticketSeat)
    {
        $this->ticketSeat = $ticketSeat;
    }
    public function getTicketSeat()
    {
        return $this->ticketSeat;
    }
    public function setTicketSeats($ticketSeats)
    {
        $this->ticketSeats = $ticketSeats;
    }
    public function getTicketSeats()
    {
        return $this->ticketSeats;
    }
    public function setTransitOperatorName(Google_Service_Walletobjects_LocalizedString $transitOperatorName)
    {
        $this->transitOperatorName = $transitOperatorName;
    }
    public function getTransitOperatorName()
    {
        return $this->transitOperatorName;
    }
    public function setTransitTerminusName(Google_Service_Walletobjects_LocalizedString $transitTerminusName)
    {
        $this->transitTerminusName = $transitTerminusName;
    }
    public function getTransitTerminusName()
    {
        return $this->transitTerminusName;
    }
    public function setZone($zone)
    {
        $this->zone = $zone;
    }
    public function getZone()
    {
        return $this->zone;
    }
}
