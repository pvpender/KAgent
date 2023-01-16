<?php

use pvpender\KAgent\UserAgentParser;
use PHPUnit\Framework\TestCase;


class UserAgentParserTest extends TestCase {

    /**
     *
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
     * @dataProvider userAgentDataProvider
     * @param mixed[] $array
     */
    public function test_parse(string $string, $array) {
        $parser = new UserAgentParser();
        $result = $parser->parse($string);
        $this->assertSame($array["platform"], $result->platform());
        $this->assertSame($array["browser"], $result->browser());
        $this->assertSame($array["version"], $result->browserVersion());
    }

    /*public function test_kphpparse(){
        $out = [];
        $uas = json_decode(file_get_contents("/home/nic/Документы/KAgent/tests/user_agents_sameples.json"), true);
        $parser = new UserAgentParser();
        foreach( $uas as $string => $parts ) {
            $out[] = [ (string)$string, $parts ];
        }
        foreach ($out as $array){
            $result = $parser->parse((string)$array[0]);
            $this->assertSame($array[1]["platform"], $result->platform());
            $this->assertSame($array[1]["browser"], $result->browser());
            $this->assertSame($array[1]["version"], $result->browserVersion());
        }
    }*/

}