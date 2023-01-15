KAgent
=======

[![Total Downloads](http://poser.pugx.org/pvpender/kagent/downloads)](https://packagist.org/packages/pvpender/kagent)
[![PHP Version Require](http://poser.pugx.org/pvpender/kagent/require/php)](https://packagist.org/packages/pvpender/kagent)

Simple library to parsing user-agent in KPHP.

[Download a latest package](https://github.com/pvpender/kagent/releases) or use [Composer](http://getcomposer.org/):

```
composer require pvpender/kagent
```

-----
Requirements 
=======
Library require php 7.4 and the latest version of [KPHP](https://github.com/VKCOM/kphp)

-----
Before starting
===
If you want to get an os version, user-agent **is not reliable source!** 

However, there are several undetectable things:
- **Brave** browser
- **iPadOs 13+**
----
Usage
===
```php
use pvpender\KAgent\UserAgentParser;

$parser = new UserAgentParser();
$ua = $parser->parse();
echo $ua->platform();
echo $ua->browser();
echo $ua->browserVersion();
```
You also can insert string in `parse()` method:
```php
$parser = new UserAgentParser();
$ua = $parser->parse("Mozilla\/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident\/3.1; Xbox)");
//it's work
```
----
List of detecting platforms 
====
| Constant | Platform |  
|----------|----------|  
| `Platforms::MACINTOSH` |  Macintosh |  
| `Platforms::CHROME_OS` |  Chrome OS |  
| `Platforms::LINUX` |  Linux |  
| `Platforms::WINDOWS` |  Windows |  
| `Platforms::ANDROID` |  Android |  
| `Platforms::BLACKBERRY` |  BlackBerry |  
| `Platforms::FREEBSD` |  FreeBSD |  
| `Platforms::IPAD` |  iPad |  
| `Platforms::IPHONE` |  iPhone |  
| `Platforms::IPOD` |  iPod |  
| `Platforms::KINDLE` |  Kindle |  
| `Platforms::KINDLE_FIRE` |  Kindle Fire |  
| `Platforms::NETBSD` |  NetBSD |  
| `Platforms::NEW_NINTENDO_3DS` |  New Nintendo 3DS |  
| `Platforms::NINTENDO_3DS` |  Nintendo 3DS |  
| `Platforms::NINTENDO_DS` |  Nintendo DS |  
| `Platforms::NINTENDO_SWITCH` |  Nintendo Switch |  
| `Platforms::NINTENDO_WII` |  Nintendo Wii |  
| `Platforms::NINTENDO_WIIU` |  Nintendo WiiU |  
| `Platforms::OPENBSD` |  OpenBSD |  
| `Platforms::PLAYBOOK` |  PlayBook |  
| `Platforms::PLAYSTATION_3` |  PlayStation 3 |  
| `Platforms::PLAYSTATION_4` |  PlayStation 4 |  
| `Platforms::PLAYSTATION_5` |  PlayStation 5 |  
| `Platforms::PLAYSTATION_VITA` |  PlayStation Vita |  
| `Platforms::SAILFISH` |  Sailfish |  
| `Platforms::SYMBIAN` |  Symbian |  
| `Platforms::TIZEN` |  Tizen |  
| `Platforms::WINDOWS_PHONE` |  Windows Phone |  
| `Platforms::XBOX` |  Xbox |  
| `Platforms::XBOX_ONE` |  Xbox One |

# List of detecting browsers

| Constant | Browser |  
|----------|----------|  
| `Browsers::ADSBOT_GOOGLE` |  AdsBot-Google |  
| `Browsers::ANDROID_BROWSER` |  Android Browser |  
| `Browsers::APPLEBOT` |  Applebot |  
| `Browsers::BAIDUSPIDER` |  Baiduspider |  
| `Browsers::BINGBOT` |  bingbot |  
| `Browsers::BLACKBERRY_BROWSER` |  BlackBerry Browser |  
| `Browsers::BROWSER` |  Browser |  
| `Browsers::BUNJALLOO` |  Bunjalloo |  
| `Browsers::CAMINO` |  Camino |  
| `Browsers::CHROME` |  Chrome |  
| `Browsers::CURL` |  curl |  
| `Browsers::EDGE` |  Edge |  
| `Browsers::FACEBOOKEXTERNALHIT` |  facebookexternalhit |  
| `Browsers::FEEDVALIDATOR` |  FeedValidator |  
| `Browsers::FIREFOX` |  Firefox |  
| `Browsers::GOOGLEBOT` |  Googlebot |  
| `Browsers::GOOGLEBOT_IMAGE` |  Googlebot-Image |  
| `Browsers::GOOGLEBOT_VIDEO` |  Googlebot-Video |  
| `Browsers::HEADLESSCHROME` |  HeadlessChrome |  
| `Browsers::IEMOBILE` |  IEMobile |  
| `Browsers::IMESSAGEBOT` |  iMessageBot |  
| `Browsers::KINDLE` |  Kindle |  
| `Browsers::LYNX` |  Lynx |  
| `Browsers::MIDORI` |  Midori |  
| `Browsers::MIUIBROWSER` |  MiuiBrowser |  
| `Browsers::MSIE` |  MSIE |  
| `Browsers::MSNBOT_MEDIA` |  msnbot-media |  
| `Browsers::NETFRONT` |  NetFront |  
| `Browsers::NINTENDOBROWSER` |  NintendoBrowser |  
| `Browsers::OCULUSBROWSER` |  OculusBrowser |  
| `Browsers::OPERA` |  Opera |  
| `Browsers::PUFFIN` |  Puffin |  
| `Browsers::SAFARI` |  Safari |  
| `Browsers::SAILFISHBROWSER` |  SailfishBrowser |  
| `Browsers::SAMSUNGBROWSER` |  SamsungBrowser |  
| `Browsers::SILK` |  Silk |  
| `Browsers::TELEGRAMBOT` |  TelegramBot |  
| `Browsers::TIZENBROWSER` |  TizenBrowser |  
| `Browsers::TWITTERBOT` |  Twitterbot |  
| `Browsers::UC_BROWSER` |  UC Browser |  
| `Browsers::VALVE_STEAM_TENFOOT` |  Valve Steam Tenfoot |  
| `Browsers::VIVALDI` |  Vivaldi |  
| `Browsers::WGET` |  Wget |  
| `Browsers::WORDPRESS` |  WordPress |  
| `Browsers::YANDEX` |  Yandex |  
| `Browsers::YANDEXBOT` |  YandexBot |

Based on  https://github.com/donatj/PhpUserAgent