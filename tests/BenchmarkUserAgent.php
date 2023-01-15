<?php

use pvpender\KAgent\UserAgentParser;

class BenchmarkUserAgeng{
    public function benchmarkParse(){
        $out = [];
        $uas = json_decode(file_get_contents("/home/nic/Документы/KAgent/tests/user_agents_sameples.json"), true);
        $parser = new UserAgentParser();
        foreach( $uas as $string => $parts ) {
            $out[] = [ (string)$string, $parts ];
        }
        foreach ($out as $array){
            $result = $parser->parse((string)$array[0]);
        }
    }
}