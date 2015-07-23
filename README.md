# HelloSalesforceBundle

[![Latest Stable Version](https://poser.pugx.org/hgtan/salesforce-bundle/v/stable)](https://packagist.org/packages/hgtan/salesforce-bundle) 
[![Total Downloads](https://poser.pugx.org/hgtan/salesforce-bundle/downloads)](https://packagist.org/packages/hgtan/salesforce-bundle) 
[![Latest Unstable Version](https://poser.pugx.org/hgtan/salesforce-bundle/v/unstable)](https://packagist.org/packages/hgtan/salesforce-bundle) 
[![License](https://poser.pugx.org/hgtan/salesforce-bundle/license)](https://packagist.org/packages/hgtan/salesforce-bundle)

[![Build Status](https://img.shields.io/travis/FriendsOfBundle/HelloSalesforceBundle.svg?style=flat-square)](https://travis-ci.org/FriendsOfBundle/HelloSalesforceBundle)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/FriendsOfBundle/HelloSalesforceBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/FriendsOfBundle/HelloSalesforceBundle/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/FriendsOfBundle/HelloSalesforceBundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/FriendsOfBundle/HelloSalesforceBundle)
[![HHVM Status](https://img.shields.io/hhvm/hgtan/salesforce-bundle.svg?style=flat-square)](http://hhvm.h4cc.de/package/hgtan/salesforce-bundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/56bfaeeb-6ea8-4bba-9b04-bf669c425277/big.png)](https://insight.sensiolabs.com/projects/56bfaeeb-6ea8-4bba-9b04-bf669c425277)

Just a simple example bundle using Salesforce API from your Symfony2 project and the following PHPForce Soap Client:
* [soap-client](https://github.com/phpforce/soap-client)

Installation
------------

### Step 1: Using Composer

composer.json
```
    php composer.phar require hgtan/salesforce-bundle:dev-master
```

### Step 2 : Register the bundle

Then register the bundle with your kernel:

```
    <?php

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Hgtan\Bundle\HelloSalesforceBundle\HgtanHelloSalesforceBundle(),
        // ...
    );
```

### Step 3 : Configure the bundle

```
    # app/config/config.yml
    hgtan_hello_salesforce:
        soap_client:
            wsdl: %kernel.root_dir%/../src/Hgtan/Bundle/HelloSalesforceBundle/Resources/wsdl/sandbox.enterprise.wsdl.xml
            username: username
            password: password
            token: security_token
            logging: true
```

### Step 4 : Test
```
    $ php app/console server:run
    
    # Fetch latest WSDL from Salesforce and store it locally
    $ php app/console phpforce:refresh-wsdl


```
Example:
```
    http://127.0.0.1:8000/salesforce/account/pull
    http://127.0.0.1:8000/salesforce/account/insert
    http://127.0.0.1:8000/salesforce/account/update
    http://127.0.0.1:8000/salesforce/account/delete
    http://127.0.0.1:8000/salesforce/account/upsert

```