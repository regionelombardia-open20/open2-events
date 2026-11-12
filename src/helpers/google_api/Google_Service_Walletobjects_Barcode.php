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

class Google_Service_Walletobjects_Barcode extends Google_Model
{
    protected $internal_gapi_mappings = array(
    );
    public $alternateText;
    public $kind;
    public $renderEncoding;
    protected $showCodeTextType = 'Google_Service_Walletobjects_LocalizedString';
    protected $showCodeTextDataType = '';
    public $type;
    public $value;


    public function setAlternateText($alternateText)
    {
        $this->alternateText = $alternateText;
    }
    public function getAlternateText()
    {
        return $this->alternateText;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setRenderEncoding($renderEncoding)
    {
        $this->renderEncoding = $renderEncoding;
    }
    public function getRenderEncoding()
    {
        return $this->renderEncoding;
    }
    public function setShowCodeText(Google_Service_Walletobjects_LocalizedString $showCodeText)
    {
        $this->showCodeText = $showCodeText;
    }
    public function getShowCodeText()
    {
        return $this->showCodeText;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
}
