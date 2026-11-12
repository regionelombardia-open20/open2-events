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

class Google_Service_Walletobjects_EventDateTime extends Google_Model
{
    protected $internal_gapi_mappings = array(
    );
    protected $customDoorsOpenLabelType = 'Google_Service_Walletobjects_LocalizedString';
    protected $customDoorsOpenLabelDataType = '';
    public $doorsOpen;
    public $doorsOpenLabel;
    public $end;
    public $kind;
    public $start;


    public function setCustomDoorsOpenLabel(Google_Service_Walletobjects_LocalizedString $customDoorsOpenLabel)
    {
        $this->customDoorsOpenLabel = $customDoorsOpenLabel;
    }
    public function getCustomDoorsOpenLabel()
    {
        return $this->customDoorsOpenLabel;
    }
    public function setDoorsOpen($doorsOpen)
    {
        $this->doorsOpen = $doorsOpen;
    }
    public function getDoorsOpen()
    {
        return $this->doorsOpen;
    }
    public function setDoorsOpenLabel($doorsOpenLabel)
    {
        $this->doorsOpenLabel = $doorsOpenLabel;
    }
    public function getDoorsOpenLabel()
    {
        return $this->doorsOpenLabel;
    }
    public function setEnd($end)
    {
        $this->end = $end;
    }
    public function getEnd()
    {
        return $this->end;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setStart($start)
    {
        $this->start = $start;
    }
    public function getStart()
    {
        return $this->start;
    }
}
