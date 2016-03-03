<?php
/**
 * Created by PhpStorm.
 * User: allentsai
 * Date: 12/7/15
 * Time: 3:00 PM
 */
use PaperG\FirehoundBlob\CampaignData\ExchangeTargeting;

class ExchangeTargetingTest extends \PHPUnit_Framework_TestCase
{
    public function test_getSetFacebook_shouldReturnCorrectValue()
    {
        $exchangeTarget = new ExchangeTargeting(false, false);
        $this->assertFalse($exchangeTarget->getFacebook());
        $exchangeTarget->setFacebook(true);
        $this->assertTrue($exchangeTarget->getFacebook());
    }

    public function test_isValid_shouldReturnCorrectResults()
    {
        $exchangeTarget = new ExchangeTargeting(false, false);
        $this->assertFalse($exchangeTarget->isValid());
        $exchangeTarget->setAppnexus(true);
        $this->assertTrue($exchangeTarget->isValid());
    }

    public function test_toFromAssociativeArray_shouldCreateCorrectObject()
    {
        $exchangeTargeting = new ExchangeTargeting(false, true);
        $array = $exchangeTargeting->toAssociativeArray();
        $newExchangeTarget = ExchangeTargeting::fromAssociativeArray($array);
        $this->assertEquals($exchangeTargeting->getFacebook(), $newExchangeTarget->getFacebook());
        $this->assertEquals($exchangeTargeting->getAppnexus(), $newExchangeTarget->getAppnexus());
    }
} 
