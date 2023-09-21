<?php

use Petschko\DHL\Credentials;
use Petschko\DHL\BusinessShipment;
use \PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{

    /**
     * Checks, if the tests are running against the actual version
     */
    public function testGetVersion()
    {
        $credentials = new Credentials();
        $shipment = new BusinessShipment($credentials);
        $this->assertEquals(2.2, $shipment->getVersion());
    }
}