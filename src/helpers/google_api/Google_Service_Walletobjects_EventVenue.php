<?php
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
