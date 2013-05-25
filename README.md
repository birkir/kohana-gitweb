# Kohana Gitweb Module

This module is an open source Git Repository web interface inspired by [GitHub](http://github.com), built for Kohana 3.3 and uses a nice GitElephant library, that was written for Symphony.

## Documentation

This project does not include any documentation other than auto generated api documentation with userguide module.

## Installation

Just extract/clone the module to your modules directory. Then edit your config/gitweb.php to point to the repository you want to track.

``` bash
$ git submodule add git://github.com/birkir/kohana-gitweb.git modules/gitweb
$ git submodule update --init --recursive
$ cd modules/gitweb
$ curl -s https://getcomposer.org/installer | php
$ composer install
```

## Future plans

Adding Issue tracker, wikis and other stuff that GitHub has. We will be using ORM module for data source.

## Other projects that made Gitweb possible

 - [Twitter Bootstrap](http://twitter.github.io/bootstrap/)
 - [TODC Bootstrap](http://todc.github.io/todc-bootstrap/)
 - [acmetech todc-bootstrap-3](http://acmetech.github.io/todc-bootstrap-3/)
 - [GitElephant](http://github.com/matteosister/GitElephant)
 - [Markdown](http://github.com/michelf/php-markdown/)
