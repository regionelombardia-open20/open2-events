<?php
namespace open20\amos\events\helpers\google_api;

/*
 * Copyleft 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Walletobjects_TimeInterval extends \Google_Model
{
  protected $internal_gapi_mappings = array(
  );
  protected $endType = 'Google_Service_Walletobjects_DateTime';
  protected $endDataType = '';
  public $kind;
  protected $startType = 'Google_Service_Walletobjects_DateTime';
  protected $startDataType = '';


  public function setEnd(Google_Service_Walletobjects_DateTime $end)
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
  public function setStart(Google_Service_Walletobjects_DateTime $start)
  {
    $this->start = $start;
  }
  public function getStart()
  {
    return $this->start;
  }
}