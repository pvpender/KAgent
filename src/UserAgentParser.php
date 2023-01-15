<?php

namespace pvpender\KAgent;

use InvalidArgumentException;

class UserAgentParser {

    private const PLATFORM        = 'platform';
    private const BROWSER         = 'browser';
    private const BROWSER_VERSION = 'version';

    /**
     * Parses a user agent string into its important parts, provide an object
     *
     * @param ?string $u_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
     * @return UserAgent an object with 'browser', 'browserVersion' and 'platform' methods
     * @throws InvalidArgumentException on not having a proper user agent to parse.
     *
     */
    public function parse( $u_agent = null ) {
        $parsed = $this->parse_user_agent($u_agent);
        return new UserAgent(
            empty(str_replace("\\", "", $parsed[self::PLATFORM]))?null:str_replace("\\", "", $parsed[self::PLATFORM]),
            empty(str_replace("\\", "", $parsed[self::BROWSER]))?null:str_replace("\\", "", $parsed[self::BROWSER]),
            empty($parsed[self::BROWSER_VERSION])?null:$parsed[self::BROWSER_VERSION]
        );
    }

    /**
     * Parses a user agent string into its important parts
     *
     * @param ?string $u_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
     * @return (?string)[] an array with 'browser', 'version' and 'platform' keys
     * @throws InvalidArgumentException on not having a proper user agent to parse.
     */
    private function parse_user_agent( $u_agent = null ) {
        if( $u_agent === null && isset($_SERVER['HTTP_USER_AGENT']) ) {
            $u_agent = (string)$_SERVER['HTTP_USER_AGENT'];
        }
        if( $u_agent === null ) {
            throw new InvalidArgumentException('parse_user_agent requires a user agent');
        }
        /** @var ?string $platform */
        $platform = "";
        /** @var ?string $browser */
        $browser  = "";
        /** @var ?string $version */
        $version  = "";

        $return = [ self::PLATFORM => (string)$platform, self::BROWSER => (string)$browser, self::BROWSER_VERSION => (string)$version ];

        if( !$u_agent ) {
            return $return;
        }
        if( preg_match('/\((.*?)\)/m', $u_agent, $parent_matches) ) {
            preg_match_all(<<<'REGEX'
/(?P<platform>BB\d+;|Android|Adr|Symbian|Sailfish|CrOS|Tizen|iPhone|iPad|iPod|Linux|(?:Open|Net|Free)BSD|Macintosh|
Windows(?:\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(?:New\ )?Nintendo\ (?:WiiU?|3?DS|Switch)|Xbox(?:\ One)?)
(?:\ [^;]*)?
(?:;|$)/imx
REGEX
                , $parent_matches[1], $result);

            $priority = [ 'Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'FreeBSD', 'NetBSD', 'OpenBSD', 'CrOS', 'X11', 'Sailfish' ];
            $result[self::PLATFORM] = array_unique($result[self::PLATFORM]);
            if( count($result[self::PLATFORM]) > 1 ) {
                if( $keys = array_intersect($priority, $result[self::PLATFORM]) ) {
                    $platform = (string)array_shift($keys);
                } else {
                    $platform = (string)$result[self::PLATFORM][0];
                }
            } elseif( isset($result[self::PLATFORM][0]) ) {
                $platform = (string)$result[self::PLATFORM][0];
            }
        }
        if( $platform == 'linux-gnu' || $platform == 'X11' ) {
            $platform = 'Linux';
        } elseif( $platform == 'CrOS' ) {
            $platform = 'Chrome OS';
        } elseif( $platform == 'Adr' ) {
            $platform = 'Android';
        } elseif( $platform == null ) {
            if(preg_match_all('%(?P<platform>Android)[:/ ]%ix', $u_agent, $result)) {
                $platform = (string)$result[self::PLATFORM][0];
            }
        }
        preg_match_all(<<<'REGEX'
%(?P<browser>Camino\\|Kindle(\ Fire)?|Kindle\\|Firefox\\|Iceweasel\\|IceCat\\|Safari\\|MSIE|Trident\\|AppleWebKit\\|
TizenBrowser\\|(?:Headless)?Chrome\\|YaBrowser\\|Vivaldi\\|IEMobile\\|Opera\\|OPR\\|Opera|Silk\\|Midori\\|(?-i:Edge)\\|EdgA?\\|CriOS\\|UCBrowser\\|Puffin\\|
OculusBrowser\\|SamsungBrowser\\|SailfishBrowser\\|XiaoMi\\/MiuiBrowser\\|
Baiduspider\\|Applebot\\|Facebot\\|Googlebot\\|YandexBot\\|bingbot\\|Lynx\\|Version\\|Wget\\|curl\\|
Valve\ Steam\ Tenfoot\\|Browser\\/AppleWebKit|
NintendoBrowser\\|PLAYSTATION\ (?:\d|Vita)+(\\)?)
\)?;?
(?:[:/ ](?P<version>[0-9A-Z.]+)|/[A-Z]*)%ix
REGEX
            , $u_agent, $result);
        // If nothing matched, return null (to avoid undefined index errors)
        if( !isset($result[self::BROWSER][0], $result[self::BROWSER_VERSION][0]) ) {
            if( preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(\\/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result) ) {
                $vers = "";
                preg_match('%\\/(?P<version>[0-9.]+)%ix', $u_agent, $vers);
                return [ self::PLATFORM => empty((string)$platform) ?null : (string)$platform, self::BROWSER => (string)$result[self::BROWSER], self::BROWSER_VERSION => empty($vers) ? null : (string)$vers[self::BROWSER_VERSION]];
            }

            return $return;
        }

        if( preg_match('/rv:(?P<version>[0-9A-Z.]+)/i', $u_agent, $rv_result) ) {
            $rv_result = (string)$rv_result[self::BROWSER_VERSION];
        }

        $browser = (string)$result[self::BROWSER][0];
        $version = (string)$result[self::BROWSER_VERSION][0];
        $lowerBrowser = array_map('strtolower', explode("+", implode("+",$result[self::BROWSER])));

        $find = function (array $search, ?string &$key, ?string &$value) use ( $lowerBrowser ) {
            foreach( $search as $val ) {
                $xkey = (string)array_search(strtolower((string)$val), $lowerBrowser);

                if( $xkey !== "") {
                    $value = (string)$val;
                    $key   = $xkey;
                    return true;
                }
            }

            return false;
        };

        $findT = function (array $search, ?string &$key, ?string &$value) use ( $find ) {
            $value2 = "";
            if( $find(array_keys($search), $key, $value2) ) {
                $value = (string)$search[$value2];
                return true;
            }

            return false;
        };

        $key = "";
        $val = "";
        $nullKey = "";
        $nullVal = "";
        if( $findT([ 'OPR\\' => 'Opera\\', 'Facebot\\' => 'iMessageBot\\', 'UCBrowser\\' => 'UC Browser\\', 'YaBrowser\\' => 'Yandex\\', 'Iceweasel\\' => 'Firefox\\', 'Icecat\\' => 'Firefox\\', 'CriOS\\' => 'Chrome\\', 'Edg\\' => 'Edge\\', 'EdgA\\' => 'Edge\\', 'XiaoMi\\/MiuiBrowser\\' => 'MiuiBrowser\\' ], $key, $browser) ) {
            $version = is_numeric(substr($result[self::BROWSER_VERSION][(int)$key], 0, 1)) ? (string)$result[self::BROWSER_VERSION][(int)$key] : "";
        } elseif( $find(['Playstation Vita'], $key, $platform) ) {
            $platform = 'PlayStation Vita';
            $browser  = 'Browser';
        } elseif( $find([ 'Kindle Fire\\', 'Silk\\', 'Kindle Fire' ], $key, $val) ) {
            $browser  = $val == 'Silk\\' ? 'Silk' : 'Kindle';
            $platform = 'Kindle Fire';
            if( !($version = (string)$result[self::BROWSER_VERSION][$key]) || !is_numeric($version[0]) ) {
                $version = (string)$result[self::BROWSER_VERSION][array_search('Version\\', $result[self::BROWSER])];
            }
        } elseif( $find(['NintendoBrowser\\'], $key, $nullVal) || $platform == 'Nintendo 3DS' ) {
            $browser = 'NintendoBrowser';
            $version = (string)$result[self::BROWSER_VERSION][empty($key)?0:$key];
        } elseif( $find(['Kindle\\'], $key, $platform) ) {
            $browser = (string)$result[self::BROWSER][empty($key)?0:$key];
            $version = (string)$result[self::BROWSER_VERSION][empty($key)?0:$key];
        } elseif( $find(['Opera\\', 'Opera'], $key, $browser) ) {
            $find(['Version\\'], $key, $nullVal);
            $version = (string)$result[self::BROWSER_VERSION][empty($key)?0:$key];
        } elseif( $find(['Puffin\\'], $key, $browser) ) {
            $version = (string)$result[self::BROWSER_VERSION][empty($key)?0:$key];
            if( strlen($version) > 3 ) {
                $part = substr($version, -2);
                if(!preg_match("/[\d\sa-z]/",$part) ) {

                    $version = (string)substr($version, 0, -2);

                    $flags = [ 'IP' => 'iPhone', 'IT' => 'iPad', 'AP' => 'Android', 'AT' => 'Android', 'WP' => 'Windows Phone', 'WT' => 'Windows' ];
                    if( isset($flags[$part]) ) {
                        $platform = (string)$flags[$part];
                    }
                }
            }
        } elseif( $find([ 'Applebot\\', 'IEMobile\\', 'Edge\\', 'Midori\\', 'Vivaldi\\', 'OculusBrowser\\', 'SamsungBrowser\\', 'Valve Steam Tenfoot\\', 'Chrome\\', 'HeadlessChrome\\', 'SailfishBrowser\\' ], $key, $browser) ) {
            $version = (string)$result[self::BROWSER_VERSION][$key];
        } elseif( $rv_result && $find(['Trident\\'], $nullKey, $nullVal) ) {
            $browser = 'MSIE';
            $version = (string)$rv_result;
        } elseif( $browser == 'AppleWebKit\\' || $browser == "Browser\\/AppleWebKit") {
            if( $platform == 'Android' ) {
                $browser = 'Android Browser';
            } elseif( strpos($platform, 'BB') === 0 ) {
                $browser  = 'BlackBerry Browser';
                $platform = 'BlackBerry';
            } elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
                $browser = 'BlackBerry Browser';
            } else {
                $find(['Safari\\'], $key, $browser) || $find(['TizenBrowser\\'], $key, $browser);
            }

            $find(['Version\\'], $key, $nullVal);
            $version = (string)$result[self::BROWSER_VERSION][empty($key)?0:$key];
        } else{
            $pKey = [];
            foreach ($result[self::BROWSER] as $s){
                if (preg_match('/playstation \d/i', $s, $pKey)){
                    break;
                }
            }
            if($pKey) {
                $platform = 'PlayStation ' . preg_replace('/\D/', '', $pKey[0]);
                $browser = 'NetFront';
            }
        }
        $return = [ self::PLATFORM => $platform, self::BROWSER => $browser, self::BROWSER_VERSION => $version ];
        return $return;
    }
}