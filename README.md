amos-attachments
----------------

Extension for file uploading and attaching to the models

Demo
----
You can see the demo on the [krajee](http://plugins.krajee.com/file-input/demo) website

Installation
------------

1. The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer require open20/amos-events
```

or add

```
"open20/amos-events": ">=1.0"
```

to the require section of your `composer.json` file.

2.  Add module to your main config in common:
	
```php
'modules' => [
    'events' => [
        'class' => 'open20\amos\events\AmosEvents',
    ],
]
```

3. Apply migrations

```bash
php yii migrate/up --migrationPath=@vendor/open20/amos-attachments/src/migrations
```


### Configurable fields

Here the list of configurable fields, properties of module AmosEvents.
If some property default is not suitable for your project, you can configure it in module, eg: 


* **ticketPasses** - array, default = null  
Enable on a field on the section advanced of events update, The filed enable Google pass and Apple  wallet for the ticket of an event

set in common/modules-amos
```php
'events' => [
      'class' => 'open20\amos\events\AmosEvents',
      'ticketPasses' => [
            'main-color' => "#297a38",
            'logo' => '/img/logo-poi-negativo.png',
            'enabled' => true
        ]
 ]
```

set in params-local
```php
  'googleApi' => [
         'serviceAccountEmail' => 'ticket-openinnovation@openinnovationlombardia-183011.iam.gserviceaccount.com',
         'serviceAccountFile' => '@common/uploads/google/openinnovationlombardia-183011-21f31d428ec6.json',
         'issuerId' => '3388000000002631420'
     ],
     'appleApi' => [
         'p12CertificateFile' => '@common/uploads/apple/AppleWalletOpenInnovation.p12',
         'p12CertificatePassword' => '(/H&t8g)',
         'teamIdentifier' => '88GK6MG45D',
         'passTypeIdentifier' => 'pass.openinnovation',
         'privateKey' => '@common/uploads/apple/AuthKey8Z665DFHCW.p8',
     ]
```
you have to generate the privates/publics keys for apple ad google and uploads to the platform
	

