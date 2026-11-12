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

class Google_Service_Walletobjects_SmartTap extends \Google_Collection
{
    protected $collection_key = 'infos';
    protected $internal_gapi_mappings = array(
    );
    public $id;
    protected $infosType = 'Google_Service_Walletobjects_IssuerToUserInfo';
    protected $infosDataType = 'array';
    public $kind;
    public $merchantId;


    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setInfos($infos)
    {
        $this->infos = $infos;
    }
    public function getInfos()
    {
        return $this->infos;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }
    public function getMerchantId()
    {
        return $this->merchantId;
    }
}
