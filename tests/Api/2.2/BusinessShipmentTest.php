<?php

use Petschko\DHL\Credentials;
use Petschko\DHL\Response;
use Petschko\DHL\Sender;
use Petschko\DHL\Receiver;
use Petschko\DHL\BusinessShipment;
use \PHPUnit\Framework\TestCase;
use Petschko\DHL\ShipmentDetails;

class BusinessShipmentTest extends TestCase
{
    /**
     * @var $receiver Receiver
     */
    protected $receiver;

    /**
     * @var $sender Sender
     */
    protected $sender;

    /**
     * @var $credentials Credentials
     */
    protected $credentials;

    /**
     * @var $shipmentDetails ShipmentDetails
     */
    protected $shipmentDetails;

    /**
     * @var $dhl BusinessShipment
     */
    protected $dhl;

    protected $testModus;
    protected $version;
    protected $reference;

    public function setUp()
    {
        $this->testModus = true;
        $this->version = '2.2';
        $this->reference = '1';

        // Set this to true then you can skip set the "User", "Signature" and "EPK" (Just for test-Modus) else false or empty
        $this->credentials = new Credentials($this->testModus);

        // Set your API-Login
        $this->credentials->setApiUser(
            ''
        );            // Test-Modus: Your DHL-Dev-Account | Production: Your Applications-ID
        $this->credentials->setApiPassword(
            ''
        );        // Test-Modus: Your DHL-Dev-Account Password | Production: Your Applications-Token

        // Set Shipment Details
        $this->shipmentDetails = new ShipmentDetails(
            $this->credentials->getEpk(10).'0101'
        ); // Create a Shipment-Details with the first 10 digits of your EPK-Number and 0101 (?)
        $this->shipmentDetails->setShipmentDate(date('Y-m-d'));

        // Set this->sender
        $this->sender = new Sender();
        $this->sender->setName(getenv('SENDER_NAME'));
        $this->sender->setFullStreet(getenv('SENDER_FULL_STREET'));
        $this->sender->setZip(getenv('SENDER_ZIP'));
        $this->sender->setCity(getenv('SENDER_CITY'));
        $this->sender->setCountry(getenv('SENDER_COUNTRY'));
        $this->sender->setCountryISOCode(getenv('SENDER_ISO_CODE'));

        // Set this->receiver
        $this->receiver = new Receiver();
        $this->receiver->setName(getenv('RECEIVER_NAME'));
        $this->receiver->setFullStreet(getenv('RECEIVER_FULL_STREET'));
        $this->receiver->setZip(getenv('RECEIVER_ZIP'));
        $this->receiver->setCity(getenv('RECEIVER_CITY'));
        $this->receiver->setCountry(getenv('RECEIVER_COUNTRY'));
        $this->receiver->setCountryISOCode(getenv('RECEIVER_ISO_CODE'));

    }

    public function testWithoutApiCredentials()
    {
        $this->dhl = new BusinessShipment(
            $this->credentials, /*Optional*/
            $this->testModus, /*Optional*/
            $this->version
        );

        // Don't forget to assign the created objects to the DHL_BusinessShipment!
        $this->dhl->setSequenceNumber($this->reference); // Just needed for ajax or such stuff can dynamic an other value
        $this->dhl->setSender($this->sender);
        $this->dhl->setReceiver(
            $this->receiver
        ); // You can set these Object-Types here: DHL_Filial, DHL_Receiver & DHL_PackStation
        //$dhl->setReturnReceiver($returnReceiver); // Needed if you want print a return label
        $this->dhl->setShipmentDetails($this->shipmentDetails);
        $this->dhl->setLabelResponseType(BusinessShipment::RESPONSE_TYPE_URL);

        $this->dhl->createShipment();
        $this->assertEquals($this->dhl->getErrors()[0], 'Authorization Required');
    }

    public function testWithApiCredentials()
    {
        if (!getenv('API_USER') || !getenv('API_PASSWORD')) {
            throw new Exception('Set Credentials in .env!');
        }
        $this->credentials->setApiUser(getenv('API_USER'));
        $this->credentials->setApiPassword(getenv('API_PASSWORD'));

        $this->dhl = new BusinessShipment(
            $this->credentials, /*Optional*/
            $this->testModus, /*Optional*/
            $this->version
        );

        // Don't forget to assign the created objects to the DHL_BusinessShipment!
        $this->dhl->setSequenceNumber($this->reference); // Just needed for ajax or such stuff can dynamic an other value
        $this->dhl->setSender($this->sender);
        $this->dhl->setReceiver(
            $this->receiver
        ); // You can set these Object-Types here: DHL_Filial, DHL_Receiver & DHL_PackStation
        //$dhl->setReturnReceiver($returnReceiver); // Needed if you want print a return label
        $this->dhl->setShipmentDetails($this->shipmentDetails);
        $this->dhl->setLabelResponseType(BusinessShipment::RESPONSE_TYPE_URL);

        /**
         * @var $response Response
         */
        $response = $this->dhl->createShipment();
        $this->assertEquals($response->getStatusCode(),0);
        $this->assertEquals($response->getSequenceNumber(),$this->reference);

    }
}