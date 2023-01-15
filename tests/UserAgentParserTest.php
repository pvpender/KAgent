<?php

use pvpender\KAgent\UserAgentParser;

class UserAgentParserTest extends \PHPUnit\Framework\TestCase {

    /**
     * @return mixed[]
     */
    public function userAgentDataProvider() {
        $out = [];
        $uas = json_decode(file_get_contents(__DIR__."/user_agents_sameples.json"), true);
        foreach( $uas as $string => $parts ) {
            $out[] = [ (string)$string, $parts ];
        }
        return $out;
    }

    /**
     * @param string[] $array
     * @dataProvider userAgentDataProvider
     */
    public function test_parse(string $string, $array) {
        $parser = new UserAgentParser();
        $result = $parser->parse($string);
        $this->assertSame($array["platform"], $result->platform());
        $this->assertSame($array["browser"], $result->browser());
        $this->assertSame($array["version"], $result->browserVersion());
    }

}