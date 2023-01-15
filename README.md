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
Using
===
```php
use pvpender\KAgent\UserAgentParser;

$parser = new UserAgentParser();
$ua = $parser->parse();
echo $ua->platform();
echo $ua->browser();
echo $ua->browserVersion();
```

