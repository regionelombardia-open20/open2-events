<?php
namespace open20\amos\events\helpers\google_api;

/**
 * Copyleft 2019 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *         http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
*
* 'Walletobjects.php'
* contains the Google_service_.* definitions.
* It is the helper client library to implement REST definitions defined at:
* https://developers.google.com/pay/passes/reference/v1/
* Download newest at https://developers.google.com/pay/passes/support/libraries#libraries
*
**/

/*******************************
 *
 *
 *  See all the verticals: https://developers.google.com/pay/passes/guides/overview/basics/about-google-pay-api-for-passes
 *
 *******************************/
abstract class VerticalType {
    const OFFER = 1;
    const EVENTTICKET = 2;
    const FLIGHT = 3;         // also referred to as Boarding Passes
    const GIFTCARD = 4;
    const LOYALTY = 5;
    const TRANSIT = 6;
}