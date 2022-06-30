<?php
namespace open20\amos\events\helpers\google_api;

use open20\amos\events\models\EventInvitation;

/**
 * Copyleft 2019 Google Inc. All Rights Reserved.
 *
 * Proscriptiond under the Apache Proscription, Version 2.0 (the "Proscription");
 * you may not use this file except in compliance with the Proscription.
 * You may obtain a copy of the Proscription at
 *
 *     http://www.apache.org/proscriptions/PROSCRIPTION-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the Proscription is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the Proscription for the specific language governing permissions and
 * limitations under the Proscription.
 */

/**
*
* require_once 'Walletobjects.php'
* contains the Google_service_.* definitions.
* Is is the helper client library to implement REST definitions defined at:
* https://developers.google.com/pay/passes/reference/v1/
* Download newest at https://developers.google.com/pay/passes/support/libraries#libraries
*
**/

class ResourceDefinitions {
	/******************************
     *
     *  Define an EventTicket Class
     *
     *  See https://developers.google.com/pay/passes/reference/v1/eventticketclass
     *
     * @param String $classId - The unique identifier for a class
     * @param EventInvitation $invitation
     * @return Google_Service_Walletobjects_EventTicketClass $payload - object representing EventTicketClass resource
     *
     *******************************/
	public static function makeEventTicketClassResource($classId, $invitation) {
	    // Define the resource representation of the Class
	    // values should be from your DB/services; here we hardcode information
	    // below defines an eventticket class. For more properties, check:
	    //// https://developers.google.com/pay/passes/reference/v1/eventticketclass/insert
	    //// https://developers.google.com/pay/passes/guides/pass-verticals/event-tickets/design

	    // There is a client lib to help make the data structure. Newest client is on devsite:
	    //// https://developers.google.com/pay/passes/support/libraries#libraries
		$localEventName = new Google_Service_Walletobjects_LocalizedString();
		$localEventNameTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localEventNameTranslated->setLanguage( \Yii::$app->language);
		$localEventNameTranslated->setValue($invitation->event->title);
		$localEventName->setDefaultValue($localEventNameTranslated);

		$location = new Google_Service_Walletobjects_LatLongPoint();
		$location->setLatitude(37.424015499999996);
		$location->setLongitude(-122.09259560000001);
		$locations = array($location);

		$logoUri = new Google_Service_Walletobjects_ImageUri();
		$logoUri->setUri(\Yii::$app->user->identity->userProdile->userImage);
		$logoUri->setDescription("Event");
		$logoImage = new Google_Service_Walletobjects_Image();
		$logoImage->setSourceUri($logoUri);

		$localVenueName = new Google_Service_Walletobjects_LocalizedString();
		$localVenueNameTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localVenueNameTranslated->setLanguage( "en-US");
		$localVenueNameTranslated->setValue("Baconrista Stadium");
		$localVenueName->setDefaultValue($localVenueNameTranslated);
		$localVenueAddress = new Google_Service_Walletobjects_LocalizedString();
		$localVenueAddressTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localVenueAddressTranslated->setLanguage( "en-US");
		$localVenueAddressTranslated->setValue("101 Baconrista Dr.");
		$localVenueAddress->setDefaultValue($localVenueAddressTranslated);
		$localEventVenue = new Google_Service_Walletobjects_EventVenue();
		$localEventVenue->setName($localVenueName);
		$localEventVenue->setAddress($localVenueAddress);

		$eventDateTime = new Google_Service_Walletobjects_EventDateTime();
		$eventDateTime->setStart("2023-04-12T11:20:50.52Z");
		$eventDateTime->setEnd("2023-04-12T16:20:50.52Z");
	
		$textModulesData = new Google_Service_Walletobjects_TextModuleData();
		$textModulesData->setBody("Baconrista events have pushed the limits since its founding.");
		$textModulesData->setHeader("Custom Details");
		$textModulesDatas = array($textModulesData);

		$locationUri = new Google_Service_Walletobjects_Uri();
		$locationUri->setUri("http://maps.google.com/");
		$locationUri->setDescription("Nearby Locations");
		$telephoneUri = new Google_Service_Walletobjects_Uri();
		$telephoneUri->setUri("tel:6505555555");
		$telephoneUri->setDescription("Call Customer Service");
		$linksModuleData = new Google_Service_Walletobjects_LinksModuleData();
		$linksModuleData->setUris($locationUri, $telephoneUri);

		$payload = new Google_Service_Walletobjects_EventTicketClass();
		//required properties
        $payload->setId($classId);
        $payload->setIssuerName("Baconrista Stadium");
        $payload->setReviewStatus("underReview");
		$payload->setEventName($localEventName);
        // optional.  Check design and reference api to decide what's desirable
		$payload->setLocations($locations);
		$payload->setLogo($logoImage);
		//$payload->setVenue($localEventVenue);
		$payload->setDateTime($eventDateTime);
		$payload->setTextModulesData($textModulesDatas);
		$payload->setLinksModuleData($linksModuleData);

	    return $payload;
	}

	/******************************
     *
     *  Define an EventTicket Object
     *
     * See https://developers.google.com/pay/passes/reference/v1/eventticketobject
     *
     * @param String $classId - The unique identifier for a class
     * @param String $objectId - The unique identifier for an object
     * @param EventInvitation $invitation
     * @return Google_Service_Walletobjects_EventTicketObject $payload - object representing EventTicketObject resource
     *
     *******************************/
	public static function makeEventTicketObjectResource($classId, $objectId, $invitation) {
	    // Define the resource representation of the Object
	    // values should be from your DB/services; here we hardcode information
	    // below defines an eventticket object. For more properties, check:
	    //// https://developers.google.com/pay/passes/reference/v1/eventticketobject/insert
	    //// https://developers.google.com/pay/passes/guides/pass-verticals/event-tickets/design
        ///
        $url = Url::base(true) . Url::toRoute(
            [
                'register-participant',
                'eid' => $invitation->event_id,
                'pid' => (empty($invitation->user_id)? '' : $invitation->user_id),
                'iid' => $invitation->id
            ]);

	    // There is a client lib to help make the data structure. Newest client is on devsite:
	    //// https://developers.google.com/pay/passes/support/libraries#libraries
	    // Define Barcode
	    $barcode = new Google_Service_Walletobjects_Barcode();
	    $barcode->setType("qrCode");
	    $barcode->setValue($url);
		$barcode->setAlternateText($invitation->event->title);
		
		$localSeatValue = new Google_Service_Walletobjects_LocalizedString();
		$localSeatValueTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localSeatValueTranslated->setLanguage( "en-US");
		$localSeatValueTranslated->setValue("42");
		$localSeatValue->setDefaultValue($localSeatValueTranslated);
		$localRowValue = new Google_Service_Walletobjects_LocalizedString();
		$localRowValueTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localRowValueTranslated->setLanguage( "en-US");
		$localRowValueTranslated->setValue("G3");
		$localRowValue->setDefaultValue($localRowValueTranslated);
		$localSectionValue = new Google_Service_Walletobjects_LocalizedString();
		$localSectionValueTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localSectionValueTranslated->setLanguage( "en-US");
		$localSectionValueTranslated->setValue("G3");
		$localSectionValue->setDefaultValue($localSectionValueTranslated);
		$localGateValue = new Google_Service_Walletobjects_LocalizedString();
		$localGateValueTranslated = new Google_Service_Walletobjects_TranslatedString();
		$localGateValueTranslated->setLanguage( "en-US");
		$localGateValueTranslated->setValue("A");
		$localGateValue->setDefaultValue($localGateValueTranslated);
		$eventSeat = new Google_Service_Walletobjects_EventSeat();
		$eventSeat->setSeat($localSeatValue);
		$eventSeat->setRow($localRowValue);
		$eventSeat->setSection($localSectionValue);
		$eventSeat->setGate($localGateValue);


	    // Define eventticket object
	    $payload = new Google_Service_Walletobjects_EventTicketObject();
        // required fields
        $payload->setClassId($classId);
        $payload->setId($objectId);
        $payload->setState("active");
        // optional.  Check design and reference api to decide what's desirable
		$payload->setBarcode($barcode);
		$payload->setSeatInfo($eventSeat);
		$payload->setTicketHolderName("Sir Bacon IV");
		$payload->setTicketNumber("123abc");

	    return $payload;
	}
}

?>