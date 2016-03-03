<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 12/7/15
 * Time: 3:01 PM
 */

namespace PaperG\Common\Test;


use PaperG\FirehoundBlob\FirehoundBlob;

class FirehoundBlobTest extends \FirehoundBlobTestCase
{
    /**
     * @var FirehoundBlob
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new FirehoundBlob("Name", "ID", time(), time() + 1000, array(), null, null, null, null);
    }

    public function test_getSetBudget_shouldReturnCorrectValue()
    {
        $budget = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\Budget');

        $this->sut->setBudget($budget);

        $this->assertEquals($budget, $this->sut->getBudget());
    }

    public function test_getSetBudgetByKey()
    {
        $key = "foo";
        $budget = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\Budget');
        $this->sut->setBudgetByKey($key, $budget);
        $this->assertEquals(null, $this->sut->getBudget());
        $this->assertEquals($budget, $this->sut->getBudgetByKey($key));
    }

    public function test_getSetContext()
    {
        $context =  "foo";

        $this->sut->setContext($context);
        $this->assertEquals($context, $this->sut->getContext());
    }

    public function test_getSetContextByKey()
    {
        $key = "foo";
        $context = "bar";
        $this->sut->setContextByKey($key, $context);
        $this->assertEquals($context, $this->sut->getContextByKey($key));
    }

    public function test_getSetCreative()
    {
        $creative = "mock creative";

        $this->sut->setCreative($creative);
        $this->assertEquals($creative, $this->sut->getCreative());
    }

    public function test_getSetEndDate()
    {
        $end = "blah";
        $this->sut->setEndDate($end);
        $this->assertEquals($end, $this->sut->getEndDate());
    }

    public function test_getSetExchangeTargeting()
    {
        $exchangeTargeting = "mock exchange targeting";
        $this->sut->setExchangeTargeting($exchangeTargeting);
        $this->assertEquals($exchangeTargeting, $this->sut->getExchangeTargeting());
    }

    public function test_getSetIdentifier()
    {
        $id = "mock id";
        $this->sut->setIdentifier($id);
        $this->assertEquals($id, $this->sut->getIdentifier());
    }

    public function test_getSetName()
    {
        $name = "mock name";
        $this->sut->setName($name);
        $this->assertEquals($name, $this->sut->getName());
    }

    public function test_getSetPlatformTargetin()
    {
        $plat = "mock platform targeting";
        $this->sut->setPlatformTargeting($plat);
        $this->assertEquals($plat, $this->sut->getPlatformTargeting());
    }

    public function test_getSetStartDate()
    {
        $start = "start";
        $this->sut->setStartDate($start);
        $this->assertEquals($start, $this->sut->getStartDate());
    }

    public function test_getSetTargeting()
    {
        $targeting = "mock targeting";
        $this->sut->setTargeting($targeting);
        $this->assertEquals($targeting, $this->sut->getTargeting());
    }

    public function test_isValidForCreation_returnsTrueForValid()
    {
        $mockId = "id";
        $mockPlatformTargeting = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\PlatformTargeting');
        $mockPlatformTargeting->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setPlatformTargeting($mockPlatformTargeting);

        $mockExchangeTargeting = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\ExchangeTargeting');
        $mockExchangeTargeting->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setExchangeTargeting($mockExchangeTargeting);

        $mockBudget = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\Budget');
        $mockBudget->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setBudget($mockBudget);

        $mockTargeting = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\Targeting');
        $mockTargeting->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setTargeting($mockTargeting);

        $mockCreative = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\Creative');
        $mockCreative->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setCreative($mockCreative);


        $this->sut->setIdentifier($mockId);

        $forCreation = true;
        $message = '';
        $result = $this->sut->isValid($forCreation, $message);
        $this->assertTrue($result);
    }

    public function test_isValidForCreation_returnsFalseForInvalid()
    {
        $forCreation = true;
        $message = '';
        $expectedMessage = 'Platform targeting is not completed or is invalid';
        $result = $this->sut->isValid($forCreation, $message);
        $this->assertFalse($result);
        $this->assertEquals($expectedMessage, $message);
    }

    public function test_isValidNotForCreation_returnsTrueForValid()
    {
        $mockId = "id";
        $mockPlatformTargeting = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\PlatformTargeting');
        $mockPlatformTargeting->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setPlatformTargeting($mockPlatformTargeting);

        $mockExchangeTargeting = $this->buildMock('\PaperG\FirehoundBlob\CampaignData\ExchangeTargeting');
        $mockExchangeTargeting->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $this->sut->setExchangeTargeting($mockExchangeTargeting);

        $this->sut->setBudget(null);
        $this->sut->setTargeting(null);
        $this->sut->setCreative(null);


        $this->sut->setIdentifier($mockId);

        $forCreation = false;
        $message = '';
        $result = $this->sut->isValid($forCreation, $message);
        $this->assertTrue($result);
    }

    public function test_isValidNotForCreation_returnsFalseForInvalid()
    {
        $forCreation = false;
        $message = '';
        $expectedMessage = 'Platform targeting is not completed or is invalid';
        $result = $this->sut->isValid($forCreation, $message);
        $this->assertFalse($result);
        $this->assertEquals($expectedMessage, $message);
    }
} 
