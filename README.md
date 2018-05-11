# DHL PHP SDK

This *unofficial* library is wrapping some functions of the DHL SOAP API in order to easy create/delete shipments and labels.

## Installation

You can use [Composer](https://getcomposer.org/) to install the package to your project:

```
composer require petschko/dhl-php-sdk
```

The classes are then added to the autoloader automatically.

## Motivation

I had a lot of pain studying and programming the DHL SOAP API - just to wrap some bits in a lot of XML. There is a lot, but not very helpful, documentation to the API. So I decided to create some functions in an easy to use and understand library.

There is also a lot of old stuff in the Documentation, so that you can not sure if it is right...

## Requirements

- You need a DHL developer account and - as long as you want to use the API in production systems - a DHL Intraship Account.
- PHP-SOAP-Client installed + enabled on your Server

## Compatibility

This Project is written for the DHL-SOAP-API **Version 2 or higher**.

It barely supports Version 1, feel free to complete the missing functions for Version 1. They are named usually `{functionname}_v1`. They are also marked with "todo" if they are not implemented

I can't find a Documentation for Version 1 anymore, so its hard to implement them properly...

## Usage

**todo: add links for some examples here**

Please have a look at the `examples` Directory. There you can find how to use this SDK also with Code-Examples, else check the [Documentation](http://docs.petschko.org/dhl-php-sdk/index.html) for deeper knowledge.

## Code Documentation

You find Code-Examples with explanations in the `examples` Directory. I also explain how it works.

You can find a Code-Reference here: _(Doxygen)_ http://docs.petschko.org/dhl-php-sdk/index.html

## Credits

All these Persons helped to create this SDK for the DHL-API:
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

### DHL-API Version 1 Code

You can find my old Version here:
[Download old Code](https://github.com/Petschko/dhl-php-sdk/releases/download/v0.1/dhl-php-sdk_v0.1.zip)

You can also look at the Tobias Redmann's Code, I initially forked that repo. There are not a lot of his code left in my current Version, but you can find his Code better than mine... (His Version supports just DHL-SOAP-Version 1)

He also Build several Plugins for Wordpress + Woocommerce in the past. Check his [GitHub-Page](https://github.com/tobias-redmann) or his [Homepage](http://www.tricd.de)
