# DmplBuilder

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

DmplBuilder eases the process of creating DM/PL command instructions used for pen plotters and cutters.

## Install

Via Composer

``` bash
$ composer require nielsiano/dmpl-builder
```

## Requirements

The following versions of PHP are supported by this version.

* PHP 7.0

## Usage

DmplBuilder has a fluent interface which makes it easier to chain lots of instructions.

``` php
$dmplBuilder = new Nielsiano\DmplBuilder();

$dmplBuilder->penUp()
            ->plot(200, 200)
            ->penDown()
            ->velocity(100)
            ->flexCut()
            ->plot(0, 1400)
            ->plot(1900, 0)
            ->plot(0, -1400)
            ->plot(-1900, 0)
            ->penUp()
            ->cutOff();

return $dmplBuilder->compileDmpl();
```

Sending the generated DM/PL instructions to your plotter through USB can be done like so:

``` php
echo ';: ECM,U H L0,P0;V10;BP50;A100,100,R,U,200,200,-200,-200,D,0,1400,1900,0,0,-1400,-1900,0,U,200,200,e' > /dev/usb/lp0
```

Available methods include:

``` php
    $dmplBuilder->penUp()
    $dmplBuilder->cutOff()
    $dmplBuilder->penDown()
    $dmplBuilder->flexCut()
    $dmplBuilder->flipAxes()
    $dmplBuilder->regularCut()
    $dmplBuilder->changePen(int $pen)
    $dmplBuilder->plot(int $x, int $y)
    $dmplBuilder->compileDmpl(): string
    $dmplBuilder->velocity(int $velocity)
    $dmplBuilder->pressure(int $gramPressure)
    $dmplBuilder->pushCommand(string $command)
    $dmplBuilder->pushCommand(string $command)
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email nielsstampe@gmail.com instead of using the issue tracker.

## Credits

- [Niels Stampe][link-author]
- [Audio Visionary Music](https://github.com/audiovisionarymusic)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/nielsiano/dmpl-builder.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nielsiano/dmpl-builder/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nielsiano/dmpl-builder.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nielsiano/dmpl-builder.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nielsiano/dmpl-builder.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nielsiano/dmpl-builder
[link-travis]: https://travis-ci.org/nielsiano/dmpl-builder
[link-scrutinizer]: https://scrutinizer-ci.com/g/nielsiano/dmpl-builder/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nielsiano/dmpl-builder
[link-downloads]: https://packagist.org/packages/nielsiano/dmpl-builder
[link-author]: https://github.com/nielsiano
[link-contributors]: ../../contributors
