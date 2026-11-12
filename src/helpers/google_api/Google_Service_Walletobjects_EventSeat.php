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

use Google_Model;

class Google_Service_Walletobjects_EventSeat extends Google_Model
{
    protected $internal_gapi_mappings = array(
    );
    protected $gateType = 'Google_Service_Walletobjects_LocalizedString';
    protected $gateDataType = '';
    public $kind;
    protected $rowType = 'Google_Service_Walletobjects_LocalizedString';
    protected $rowDataType = '';
    protected $seatType = 'Google_Service_Walletobjects_LocalizedString';
    protected $seatDataType = '';
    protected $sectionType = 'Google_Service_Walletobjects_LocalizedString';
    protected $sectionDataType = '';


    public function setGate(Google_Service_Walletobjects_LocalizedString $gate)
    {
        $this->gate = $gate;
    }
    public function getGate()
    {
        return $this->gate;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setRow(Google_Service_Walletobjects_LocalizedString $row)
    {
        $this->row = $row;
    }
    public function getRow()
    {
        return $this->row;
    }
    public function setSeat(Google_Service_Walletobjects_LocalizedString $seat)
    {
        $this->seat = $seat;
    }
    public function getSeat()
    {
        return $this->seat;
    }
    public function setSection(Google_Service_Walletobjects_LocalizedString $section)
    {
        $this->section = $section;
    }
    public function getSection()
    {
        return $this->section;
    }
}
