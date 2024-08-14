<?php

require_once __DIR__ . '/../vendor/autoload.php';  // Include the Composer autoloader

use PHPUnit\Framework\TestCase;
require_once 'src/Metar.php';

class MetarTest extends TestCase
{
    public function testSpecificParameters()
    {
        $raw = 'UWSS 231500Z 14007MPS 9999 -SHRA BR BKN033CB OVC066 03/M02 Q1019 R12/220395 NOSIG RMK QFE752';
        $metar = new Metar($raw, FALSE, TRUE);
        $parameters = $metar->parse();

        $this->assertEquals('UWSS 231500Z 14007MPS 9999 -SHRA BR BKN033CB OVC066 03/M02 Q1019 R12/220395 NOSIG RMK QFE752', $parameters['raw']);
        $this->assertEquals(13.61, $parameters['wind_speed_kt']);
        $this->assertEquals('Broken sky at 1006 meters, cumulonimbus; overcast sky at 2012 meters', $parameters['clouds_report']);
        $this->assertEquals('Broken sky at 3300 feet, cumulonimbus; overcast sky at 6600 feet', $parameters['clouds_report_ft']);
        $this->assertEquals('QFE752', $parameters['remarks']);
    }

    public function testCloudsReport()
    {
        $raw = 'UWSS 231500Z 14007MPS 9999 -SHRA BR BKN033CB OVC066 03/M02 Q1019 R12/220395 NOSIG RMK QFE752';
        $metar = new Metar($raw, FALSE, TRUE);
        $metar->parse();

        $expected_clouds_report = 'Broken sky at 1006 meters, cumulonimbus; overcast sky at 2012 meters';

        $this->assertEquals($expected_clouds_report, $metar->clouds_report);
    }
}

