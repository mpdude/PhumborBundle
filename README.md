PhumborBundle
=============

A Symfony Bundle to use the [PHP Thumbor client](https://github.com/webfactory/phumbor) to generate Thumbor URLs in Symfony Twig templates. 
Forked from https://github.com/jbouzekri/PhumborBundle.

## Prerequisites

Of course, you must have a [Thumbor server](https://github.com/thumbor/thumbor/wiki) installed and operational.

## Installation
------------

Add `webfactory/phumbor-bundle` as a dependency in `composer.json`. Then, enable register the `Webfactory\Bundle\PhumborBundle\WebfactoryPhumborBundle`
class in your Symfony Kernel.

In your config.yml, configure at least the url of your Thumbor server and the secret :

``` yml
webfactory_phumbor:
    server:
        url: http://localhost
        secret: 123456789
```

Alternatively, you can also set the environment variables `THUMBOR_URL` and `THUMBOR_SECURITY_KEY` for these two settings, for example from your `.env`
file or from inside your webserver configuration.

Quick use case
--------------

You need to resize the image of your article to fit in a square of 50x50. Define the following transformation in your config.yml :

``` yml
webfactory_phumbor:
    transformations:
        article_list:
            fit_in: { width: 50, height: 50 }
```

Now you can use it in twig :

``` twig
{{ thumbor(<the absolute url of your image>, 'article_list') }}
```

## Documentation

* [Configuration Reference](Resources/doc/reference.md)
* [Service](Resources/doc/service.md)
* [Twig Helper](Resources/doc/twig_helper.md)

## Credits, Copyright and License

This bundle was first written by [jbouzekri](https://github.com/jbouzekri). webfactory
made contributions previously and forked the project in 2022.

- <https://www.webfactory.de>
- <https://twitter.com/webfactory>

Copyright starting 2022 – webfactory GmbH, Bonn. Code released under [the MIT license](LICENSE).
