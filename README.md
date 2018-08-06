# DHL PHP SDK

This *unofficial* library is wrapping some functions of the DHL SOAP API in order to easy create/delete shipments and labels.

## Requirements

- You need a [DHL developer Account](https://entwickler.dhl.de/) and - as long as you want to use the API in production systems - a DHL Intraship Account.
- PHP-SOAP-Client installed + enabled on your Server. [More information on php.net](http://php.net/manual/en/soap.setup.php)

## Installation

### Composer

You can use [Composer](https://getcomposer.org/) to install the package to your project:

```
composer require petschko/dhl-php-sdk
```

The classes are then added to the autoloader automatically.

### Without Composer

If you can't use Composer (or don't want to), you can also use this SDK without it.

To initial this SDK, just require the [_nonComposerLoader.php](https://github.com/Petschko/dhl-php-sdk/blob/master/includes/_nonComposerLoader.php)-File from the `/includes/` directory.

```php
require_once(__DIR__ . '/includes/_nonComposerLoader.php');
```

## Compatibility

This Project is written for the DHL-SOAP-API **Version 2 or higher**.

Version 1 Methods are marked as @deprecated and will removed soon. Please upgrade to the API-Version 2 as soon as possible.

## Usage / Getting started

- [Getting started (Just a quick guide how you have to use it)](https://github.com/Petschko/dhl-php-sdk/blob/master/examples/getting-started.md)
- _More examples soon_

Please have a look at the `examples` [Directory](https://github.com/Petschko/dhl-php-sdk/tree/master/examples). There you can find how to use this SDK also with Code-Examples, else check the _(Doxygen)_ [Documentation](http://docs.petschko.org/dhl-php-sdk/index.html) for deeper knowledge.

## Code Documentation

You find Code-Examples with explanations in the `examples` Directory. I also explain how it works.

You can find a Code-Reference here: _(Doxygen)_ http://docs.petschko.org/dhl-php-sdk/index.html

## Motivation

I had a lot of pain studying and programming the DHL SOAP API - just to wrap some bits in a lot of XML. There is a lot, but not very helpful, documentation to the API. So I decided to create some functions in an easy to use and understand library.

There is also a lot of old stuff in the Documentation, so that you can not sure if it is right...

## Credits

All these Persons helped to create this SDK for the DHL-API:
- [aschempp](https://github.com/aschempp) - For the help with the Notification E-Mail
- [cedricziel](https://github.com/cedricziel) - For turning this Project into a [Composer](https://getcomposer.org/)-Package
- [Dakror](https://github.com/Dakror) - For the `ProductInfo`-Class
- [octlabs](https://github.com/octlabs) - For adding some missing Documentation
- [Petschko](https://github.com/Petschko) - Initially created this Project and decided to share it for free
- [tobias-redmann](https://github.com/tobias-redmann) - For the `setFullStreet` method and the PHP-DHL-Example-Project for Version 1 _(This helped a lot to understand how the API works)_


## Contact

- You can E-Mail me if you have Questions or whatever (No Bug-Reporting please!): peter@petschko.org
- You can Report Bugs here in the "[Issue](https://github.com/Petschko/dhl-php-sdk/issues)"-Section of the Project.
	- Of course you can also ask any stuff there, feel free for that!
	- If you want to use German, you can do it. Please keep in mind that not everybody can speak German, so it's better to use english =)
