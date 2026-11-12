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

class Google_Service_Walletobjects_Resources extends \Google_Collection
{
    protected $collection_key = 'transitObjects';
    protected $internal_gapi_mappings = array(
    );
    protected $eventTicketClassesType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_EventTicketClass';
    protected $eventTicketClassesDataType = 'array';
    protected $eventTicketObjectsType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_EventTicketObject';
    protected $eventTicketObjectsDataType = 'array';
    protected $flightClassesType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_FlightClass';
    protected $flightClassesDataType = 'array';
    protected $flightObjectsType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_FlightObject';
    protected $flightObjectsDataType = 'array';
    protected $giftCardClassesType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_GiftCardClass';
    protected $giftCardClassesDataType = 'array';
    protected $giftCardObjectsType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_GiftCardObject';
    protected $giftCardObjectsDataType = 'array';
    protected $loyaltyClassesType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_LoyaltyClass';
    protected $loyaltyClassesDataType = 'array';
    protected $loyaltyObjectsType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_LoyaltyObject';
    protected $loyaltyObjectsDataType = 'array';
    protected $offerClassesType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_OfferClass';
    protected $offerClassesDataType = 'array';
    protected $offerObjectsType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_OfferObject';
    protected $offerObjectsDataType = 'array';
    protected $transitClassesType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_TransitClass';
    protected $transitClassesDataType = 'array';
    protected $transitObjectsType = 'open20\\amos\\events\\helpers\\google_api\\Google_Service_Walletobjects_TransitObject';
    protected $transitObjectsDataType = 'array';


    public function setEventTicketClasses($eventTicketClasses)
    {
        $this->eventTicketClasses = $eventTicketClasses;
    }
    public function getEventTicketClasses()
    {
        return $this->eventTicketClasses;
    }
    public function setEventTicketObjects($eventTicketObjects)
    {
        $this->eventTicketObjects = $eventTicketObjects;
    }
    public function getEventTicketObjects()
    {
        return $this->eventTicketObjects;
    }
    public function setFlightClasses($flightClasses)
    {
        $this->flightClasses = $flightClasses;
    }
    public function getFlightClasses()
    {
        return $this->flightClasses;
    }
    public function setFlightObjects($flightObjects)
    {
        $this->flightObjects = $flightObjects;
    }
    public function getFlightObjects()
    {
        return $this->flightObjects;
    }
    public function setGiftCardClasses($giftCardClasses)
    {
        $this->giftCardClasses = $giftCardClasses;
    }
    public function getGiftCardClasses()
    {
        return $this->giftCardClasses;
    }
    public function setGiftCardObjects($giftCardObjects)
    {
        $this->giftCardObjects = $giftCardObjects;
    }
    public function getGiftCardObjects()
    {
        return $this->giftCardObjects;
    }
    public function setLoyaltyClasses($loyaltyClasses)
    {
        $this->loyaltyClasses = $loyaltyClasses;
    }
    public function getLoyaltyClasses()
    {
        return $this->loyaltyClasses;
    }
    public function setLoyaltyObjects($loyaltyObjects)
    {
        $this->loyaltyObjects = $loyaltyObjects;
    }
    public function getLoyaltyObjects()
    {
        return $this->loyaltyObjects;
    }
    public function setOfferClasses($offerClasses)
    {
        $this->offerClasses = $offerClasses;
    }
    public function getOfferClasses()
    {
        return $this->offerClasses;
    }
    public function setOfferObjects($offerObjects)
    {
        $this->offerObjects = $offerObjects;
    }
    public function getOfferObjects()
    {
        return $this->offerObjects;
    }
    public function setTransitClasses($transitClasses)
    {
        $this->transitClasses = $transitClasses;
    }
    public function getTransitClasses()
    {
        return $this->transitClasses;
    }
    public function setTransitObjects($transitObjects)
    {
        $this->transitObjects = $transitObjects;
    }
    public function getTransitObjects()
    {
        return $this->transitObjects;
    }
}
