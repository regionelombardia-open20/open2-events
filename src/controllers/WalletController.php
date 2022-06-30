<?php

namespace open20\amos\events\controllers;

use open20\amos\core\controllers\AmosController;
use open20\amos\events\helpers\google_api\Services;
use open20\amos\events\helpers\google_api\VerticalType;
use open20\amos\events\models\Event;
use open20\amos\events\models\EventInvitation;
use yii\base\Exception;
use PKPass\PKPass;
use yii\web\ForbiddenHttpException;

class WalletController extends AmosController
{
    public function actionSaveToGoogle($id)
    {
        $googleApiParams = \Yii::$app->params['googleApi'] ?: [];

        if(empty($googleApiParams)) {
            throw new ForbiddenHttpException('Google Wallet Not Enabled');
        }

        // Identifiers of Service account
        define('SERVICE_ACCOUNT_EMAIL_ADDRESS', $googleApiParams['serviceAccountEmail']);
        define('SERVICE_ACCOUNT_FILE',\Yii::getAlias($googleApiParams['serviceAccountFile']));

        // Used by the Google Pay API for Passes Client library
        define('APPLICATION_NAME', \Yii::$app->name);

        // Identifier of Google Pay API for Passes Merchant Center
        define('ISSUER_ID', $googleApiParams['issuerId']);

        // List of origins for save to phone button. Used for JWT
        //// See https://developers.google.com/pay/passes/reference/s2w-reference
        $ORIGINS = array('https://pre-prod-sql8-clone.stage.demotestwip.it');

        // Constants that are application agnostic. Used for JWT
        define('AUDIENCE', 'google');
        define('JWT_TYPE', 'savetoandroidpay');
        define('SCOPES', 'https://www.googleapis.com/auth/wallet_object.issuer');

        // Load the private key as String from service account file
        $jsonFile = file_get_contents(SERVICE_ACCOUNT_FILE);
        $credentialJson = json_decode($jsonFile, true);
        define('SERVICE_ACCOUNT_PRIVATE_KEY',$credentialJson['private_key']);

        $services = new Services(['event_id' => $id]);
        $verticalType = VerticalType::EVENTTICKET;
        $vertical = "EVENTTICKET";
        $classUid = $vertical."_CLASS_".uniqid('', true);
        $classId = sprintf("%s.%s" , ISSUER_ID, $classUid);
        $objectUid= $vertical."_OBJECT_".uniqid('', true);
        $objectId = sprintf("%s.%s", ISSUER_ID, $objectUid);

        $skinnyJwt = $services->makeSkinnyJwt($verticalType, $classId, $objectId);

        if ($skinnyJwt  != null){
            return $this->redirect("https://pay.google.com/gp/v/save/{$skinnyJwt}");
        } else {
            return $this->redirect('/');
        }
    }

    public function actionSaveToIos($id) {
        $appleApiParams = \Yii::$app->params['appleApi'] ?: [];

        if(empty($appleApiParams)) {
            throw new ForbiddenHttpException('Apple Pass Not Enabled');
        }

        $pass = new PKPass(\Yii::getAlias($appleApiParams['p12CertificateFile']), $appleApiParams['p12CertificatePassword']);

        /**
         * @var $event Event
         */
        $event = Event::findOne(['id' => $id]);

        /**
         * @var $invitation EventInvitation
         */
        $invitation = EventInvitation::findOne(
            [
                'event_id' => $id,
                'user_id' => \Yii::$app->user->id
            ]
        );

        $qrCodeUrl = Url::base(true) . Url::toRoute(
                [
                    'register-participant',
                    'eid' => $invitation->event_id,
                    'pid' => (empty($invitation->user_id)? '' : $invitation->user_id),
                    'iid' => $invitation->id
                ]);

        // Pass content
        $data = [
            'description' => $event->title,
            'formatVersion' => 1,
            'organizationName' => \Yii::$app->name,
            'passTypeIdentifier' => 'event.pass.type',
            'serialNumber' => $invitation->id,
            'teamIdentifier' => $invitation->id.$event->id,
            /*'boardingPass' => [
                'primaryFields' => [
                    [
                        'key' => 'origin',
                        'label' => 'San Francisco',
                        'value' => 'SFO',
                    ],
                    [
                        'key' => 'destination',
                        'label' => 'London',
                        'value' => 'LHR',
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'gate',
                        'label' => 'Gate',
                        'value' => 'F12',
                    ],
                    [
                        'key' => 'date',
                        'label' => 'Departure date',
                        'value' => '07/11/2012 10:22',
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'passenger-name',
                        'label' => 'Passenger',
                        'value' => 'John Appleseed',
                    ],
                ],
                'transitType' => 'PKTransitTypeAir',
            ],*/
            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'message' => $qrCodeUrl,
                'messageEncoding' => 'iso-8859-1',
            ],
            'backgroundColor' => 'rgb(32,110,247)',
            //'logoText' => 'Ticket',
            //'relevantDate' => date('Y-m-d\TH:i:sP')
        ];

        $pass->setData($data);

        // Add files to the pass package
        /*$pass->addFile('images/icon.png');
        $pass->addFile('images/icon@2x.png');
        $pass->addFile('images/logo.png');*/

        // Create and output the pass
        if(!$pass->create(true)) {
            throw new ForbiddenHttpException($pass->getError());
        }

        die;
    }

}