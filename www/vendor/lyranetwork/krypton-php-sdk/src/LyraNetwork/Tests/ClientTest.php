<?php
namespace LyraNetwork\Tests;

use PHPUnit_Framework_TestCase;
use LyraNetwork\Client;
use LyraNetwork\Constants;

/**
 * ./vendor/bin/phpunit src/LyraNetwork/Tests/ClientTest.php
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    private function fakePostData()
    {
        $_POST['kr-hash'] = "6ad18cd5bd4cf8b2a265c283c3a829dd58fea0db032e3f73ae670f74e1f4c7dc";
        $_POST['kr-hash-algorithm'] = "sha256";
        $_POST['kr-answer-type'] = "V3.1\/BrowserRequest";
        $_POST['kr-answer'] = '{"shopId":"33148340","orderCycle":"CLOSED","orderStatus":"PAID","orderDetails":{"orderTotalAmount":399,"orderCurrency":"EUR","mode":"TEST","orderId":"446cedc74e404af2ace4ecb4c64513fa","_type":"V3.1/OrderDetails"},"transactions":[{"uuid":"9b7ad826931542198131fd939cf88816","status":"PAID","detailedStatus":"AUTHORISED","_type":"V3.1/BrowserRequestTransaction"}],"serverDate":"2017-11-09T15:33:49+00:00","_type":"V3.1/BrowserRequest"}';
    }

    /**
     * ./vendor/bin/phpunit --filter testDefaultVersionClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testDefaultVersionClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals("V3", $response["version"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testV3ClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testV3ClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals("V3", $response["version"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testV31ClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testV31ClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3.1/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals("V3.1", $response["version"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testClientUsernamePasswordValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testClientUsernamePasswordValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername("69876357");
        $client->setPassword("testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsPrivateKeyClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testFileGetContentsPrivateKeyClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->postWithFileGetContents('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsClientValidCall src/LyraNetwork/Tests/ClientTest.php
     */
    public function testFileGetContentsClientValidCall()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername("69876357");
        $client->setPassword("testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->postWithFileGetContents('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testDoubleSlash src/LyraNetwork/Tests/ClientTest.php
     */
    public function testDoubleSlash()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu//");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testGetUrlFromTarget src/LyraNetwork/Tests/ClientTest.php
     */
    public function testGetUrlFromTarget()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");

        $client->setEndpoint("https://secure.payzen.eu");
        $this->assertEquals("https://secure.payzen.eu/api-payment/V3/Charge/Get", $client->getUrlFromTarget("V3/Charge/Get"));

        $client->setEndpoint("https://secure.payzen.eu/");
        $this->assertEquals("https://secure.payzen.eu/api-payment/V3/Charge/Get", $client->getUrlFromTarget("V3/Charge/Get"));
    }

    /**
     * ./vendor/bin/phpunit --filter testClientWrongKey src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testClientWrongKey()
    {
        $client = new Client();
        $client->setPrivateKey("wrongkey");
    }

    /**
     * ./vendor/bin/phpunit --filter testNoPrivateKey src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoPrivateKey()
    {
        $client = new Client();
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoUsername src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoUsername()
    {
        $client = new Client();
        $client->setPassword("testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoPassword src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoPassword()
    {
        $client = new Client();
        $client->setUsername("69876357");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoEndpoint src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testNoEndpoint()
    {
        $client = new Client();
        $client->setPrivateKey("A:B");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testInvalidKey src/LyraNetwork/Tests/ClientTest.php
     */
    public function testInvalidKey()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_FAKE");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_005", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsInvalidKey src/LyraNetwork/Tests/ClientTest.php
     */
    public function testFileGetContentsInvalidKey()
    {
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_FAKE");
        $client->setEndpoint("https://secure.payzen.eu");
        $response = $client->postWithFileGetContents('V3/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_005", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testClientConfiguration src/LyraNetwork/Tests/ClientTest.php
     */
    public function testClientConfiguration()
    {
        $client = new Client();
        $client->setPrivateKey("A:B");
        $client->setPublickey("33148340:testpublickey_l83P7WpRK2hoUIcWyFVQsd4Omsz0XbCKYtNKeGbpX6CvS");
        $client->setEndpoint("https://secure.payzen.eu");

        $this->assertEquals(Constants::SDK_VERSION, $client->getVersion());
        $this->assertEquals("33148340:testpublickey_l83P7WpRK2hoUIcWyFVQsd4Omsz0XbCKYtNKeGbpX6CvS", $client->getPublicKey());
        $this->assertEquals("https://secure.payzen.eu", $client->getEndpoint());
        $this->assertEquals("https://secure.payzen.eu", $client->getClientEndpoint());

        $client->setClientEndpoint("https://client.payzen.eu");
        $this->assertEquals("https://secure.payzen.eu", $client->getEndpoint());
        $this->assertEquals("https://client.payzen.eu", $client->getClientEndpoint());
    }

    /**
     * ./vendor/bin/phpunit --filter testDefaultClientConfiguration src/LyraNetwork/Tests/ClientTest.php
     */
    public function testDefaultClientConfiguration()
    {
        Client::setDefaultUsername("69876357");
        Client::setDefaultPassword("testpassword_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        Client::setDefaultPublicKey("69876357:testpublickey_DEMOPUBLICKEY95me92597fd28tGD4r5");
        Client::setDefaultEndpoint("https://secure.payzen.eu");
        Client::setDefaultClientEndpoint("https://client.payzen.eu");
        Client::setdefaultSHA256Key("38453613e7f44dc58732bad3dca2bca3");

        $client = new Client();
        $store = array("value" => "sdk test string value");
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);

        $this->assertEquals(Constants::SDK_VERSION, $client->getVersion());
        $this->assertEquals("69876357:testpublickey_DEMOPUBLICKEY95me92597fd28tGD4r5", $client->getPublicKey());
        $this->assertEquals("69876357", $client->getUsername());
        $this->assertEquals("testpassword_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M", $client->getPassword());
        $this->assertEquals("https://secure.payzen.eu", $client->getEndpoint());
        $this->assertEquals("https://client.payzen.eu", $client->getClientEndpoint());
        $this->assertEquals("38453613e7f44dc58732bad3dca2bca3", $client->getSHA256Key());
        $this->assertEquals(null, $client->getProxyHost());
        $this->assertEquals(null, $client->getProxyPort());

        Client::setDefaultProxy("simple.host", "1234");
        $client2 = new Client();
        $this->assertEquals("69876357", $client2->getUsername());
        $this->assertEquals("simple.host", $client2->getProxyHost());
        $this->assertEquals("1234", $client2->getProxyPort());

        Client::resetDefaultConfiguration();
        $client = new Client();
        $this->assertEquals(null, $client->getPublicKey());
        $this->assertEquals(null, $client->getUsername());
        $this->assertEquals(null, $client->getPassword());
        $this->assertEquals(null, $client->getEndpoint());
        $this->assertEquals(null, $client->getClientEndpoint());
        $this->assertEquals(null, $client->getSHA256Key());
        $this->assertEquals(null, $client->getProxyHost());
        $this->assertEquals(null, $client->getProxyPort());
    }

    /**
     * ./vendor/bin/phpunit --filter testFakeProxy src/LyraNetwork/Tests/ClientTest.php
     *
     * @expectedException LyraNetwork\Exceptions\LyraNetworkException
     */
    public function testFakeProxy()
    {
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");
        $client->setTimeOuts(1,1);
        $client->setProxy('fake.host', 1234);

        $store = array("value" => "sdk test string value");
        $response = $client->post('V3/Charge/SDKTest', $store);
        $this->assertEquals("fake.host", $client->getProxyHost());
        $this->assertEquals("1234", $client->getProxyPort());
    }

    /**
     * ./vendor/bin/phpunit --filter testInvalidAnswer src/LyraNetwork/Tests/ClientTest.php
     */
    public function testInvalidAnswer()
    {
        $client = new Client();
        $client->setPrivateKey("69876357:testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
        $client->setEndpoint("https://secure.payzen.eu");

        $store = "FAKE";
        $response = $client->post('V3/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_002", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testGetParsedFormAnswer src/LyraNetwork/Tests/ClientTest.php
     */
    public function testGetParsedFormAnswer()
    {
        $client = new Client();
        $this->fakePostData();
        $answer = $client->getParsedFormAnswer();

        $this->assertEquals($_POST['kr-hash'], $answer['kr-hash']);
        $this->assertEquals($_POST['kr-hash-algorithm'], $answer['kr-hash-algorithm']);
        $this->assertEquals($_POST['kr-answer-type'], $answer['kr-answer-type']);

        $rebuild_string_answer = json_encode($answer['kr-answer']);
        /* php 5.3.3 does not support JSON_UNESCAPED_SLASHES */
        $rebuild_string_answer = str_replace('\/', '/', $rebuild_string_answer);

        $this->assertEquals($_POST['kr-answer'], $rebuild_string_answer);
        $this->assertEquals("array", gettype($answer['kr-answer']));
    }

    /**
     * ./vendor/bin/phpunit --filter testCheckHash src/LyraNetwork/Tests/ClientTest.php
     */
    public function testCheckHash()
    {
        $client = new Client();
        $this->fakePostData();
        $this->assertNull($client->getLastCalculatedHash());

        $client->setSHA256Key("ktM7bSeTJpclvpm4eEE9N0LIyoxUvsQ9AAYbQI1xQx7Qh");
        $isValid = $client->checkHash();

        $this->assertTrue($isValid);
        $this->assertNotNull($client->getLastCalculatedHash());
    }
}