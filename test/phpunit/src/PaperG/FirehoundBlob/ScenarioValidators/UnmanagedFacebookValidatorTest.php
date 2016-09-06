<?php
/**
 *
 * Author: zhiachong (zTime)
 * Time: 7/18/16 - 3:42 PM
 * Filename: UnmanagedFacebookValidatorTest.php
 */

namespace PaperG\Common\Test;


use PaperG\FirehoundBlob\CampaignData\Budget;
use PaperG\FirehoundBlob\Facebook\FacebookAdSet;
use PaperG\FirehoundBlob\Facebook\FacebookCreative;
use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;
use PaperG\FirehoundBlob\ScenarioValidators\UnmanagedFacebookValidator;

class UnmanagedFacebookValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UnmanagedFacebookValidator
     */
    private $sut;

    public function setup()
    {
        $this->sut = new UnmanagedFacebookValidator();
    }

    public function test_isValidCreateBlob_UsingAValidBlobForCreate_ReturnsTrue()
    {
        $mockScenarioBlob    = $this->getMockBuilder('PaperG\FirehoundBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();
        $mockUnmanagedFbBlob = new UnmanagedFacebookBlob();
        $mockAdSet           = new FacebookAdSet();
        $mockCreative        = new FacebookCreative();
        $mockCreativeData = new FacebookCreativeData();
        $mockCreativeData->setMediaUrl("media url");
        $mockCreativeData->setName('mock name');
        $mockCreative->setType('link');
        $mockCreative->setPrimary($mockCreativeData);

        $mockUnmanagedFbBlob->setAdAccountId('123-abc');
        $mockUnmanagedFbBlob->setPageId('123-abc');
        $mockUnmanagedFbBlob->setAccessToken('123-abc');
        $mockUnmanagedFbBlob->setStatus('active');
        $mockUnmanagedFbBlob->setCreatives([$mockCreative]);
        $mockUnmanagedFbBlob->setAdSets([$mockAdSet]);
        $mockScenarioBlob->expects($this->once())
                         ->method('getBlob')
                         ->will($this->returnValue($mockUnmanagedFbBlob));

        $results = $this->sut->isValidCreateBlob($mockScenarioBlob);

        $this->assertEquals(true, $results->getResult());
    }

    public function test_isValidCreateBlob_UsingAValidBlobForCreate_WithIntPage_ReturnsTrue()
    {
        $mockScenarioBlob    = $this->getMockBuilder('PaperG\FirehoundBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();
        $mockUnmanagedFbBlob = new UnmanagedFacebookBlob();
        $mockAdSet           = new FacebookAdSet();
        $mockCreative        = new FacebookCreative();
        $mockCreativeData = new FacebookCreativeData();
        $mockCreativeData->setMediaUrl("media url");
        $mockCreativeData->setName('mock name');
        $mockCreative->setType('link');
        $mockCreative->setPrimary($mockCreativeData);
        $mockBudget = new Budget(1, 'dollar', 'daily');
        $mockUnmanagedFbBlob->setAdAccountId('123-abc');
        $mockUnmanagedFbBlob->setPageId('123-abc');
        $mockUnmanagedFbBlob->setAccessToken('123-abc');
        $mockUnmanagedFbBlob->setStatus('active');
        $mockUnmanagedFbBlob->setCreatives([$mockCreative]);
        $mockUnmanagedFbBlob->setAdSets([$mockAdSet]);
        $mockUnmanagedFbBlob->setBudget($mockBudget);
        $mockScenarioBlob->expects($this->once())
            ->method('getBlob')
            ->will($this->returnValue($mockUnmanagedFbBlob));

        $results = $this->sut->isValidCreateBlob($mockScenarioBlob);
        $this->assertEquals(true, $results->getResult());
    }

    public function test_isValidCreateBlob_UsingInvalidBlobForCreate_ReturnsFalseAndErrorMessage()
    {
        $mockScenarioBlob    = $this->getMockBuilder('PaperG\FirehoundBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();

        $mockAdSet           = $this->getMockBuilder('PaperG\FirehoundBlob\Facebook\FacebookAdSet')->disableOriginalConstructor()
                                    ->getMock();
        $mockCreative        = $this->getMockBuilder('PaperG\FirehoundBlob\Facebook\FacebookCreative')->disableOriginalConstructor()
                                    ->getMock();

        $mockBudget = new Budget("invalid", "impression", "lifetime");

        $mockUnmanagedFbBlob = new UnmanagedFacebookBlob();
        $mockUnmanagedFbBlob->setAdAccountId(1123);
        $mockUnmanagedFbBlob->setPageId([1, 2, 3]);
        $mockUnmanagedFbBlob->setAccessToken(["helloworld"]);
        $mockUnmanagedFbBlob->setStatus('');
        $mockUnmanagedFbBlob->setCreatives([$mockCreative]);
        $mockUnmanagedFbBlob->setAdSets([$mockAdSet]);
        $mockUnmanagedFbBlob->setBudget($mockBudget);

        $mockScenarioBlob->expects($this->once())
            ->method('getBlob')
            ->will($this->returnValue($mockUnmanagedFbBlob));

        $results = $this->sut->isValidCreateBlob($mockScenarioBlob);

        $this->assertEquals(
            '[adAccountId] Integer value found, but a string is required. '
            . '[pageId] Array value found, but a string or a number is required. '
            . '[accessToken] Array value found, but a string is required. '
            . '[budget.amount] String value found, but a number is required. '
            . '[budget.budget_type] Does not have a value in the enumeration ["daily"]. '
            . '[budget.type] Does not have a value in the enumeration ["dollar"]. [budget] Failed to match all schemas. '
            . '[budget] Object value found, but a null is required. [budget] Failed to match exactly one schema. '
            . '[adSets[0]] NULL value found, but an object is required. [adSets] Array value found, but a null is required. '
            . '[adSets] Failed to match exactly one schema. [creatives[0]] NULL value found, but an object is required. '
            . '[creatives] Array value found, but a null is required. [creatives] Failed to match exactly one schema. '
            . '[status] Does not have a value in the enumeration ["active","inactive"]. '
            . '[] Failed to match all schemas.',
            $results->getMessage()
        );

        $this->assertEquals(false, $results->getResult());
    }

    public function test_isValidUpdateBlob_UsingInvalidBlobForUpdate_ReturnsFalseAndErrorMessage()
    {
        $mockScenarioBlob    = $this->getMockBuilder('PaperG\FirehoundBlob\ScenarioBlob')->disableOriginalConstructor()->getMock();

        $mockAdSet           = $this->getMockBuilder('PaperG\FirehoundBlob\Facebook\FacebookAdSet')->disableOriginalConstructor()
                                    ->getMock();

        $mockCreative        = $this->getMockBuilder('PaperG\FirehoundBlob\Facebook\FacebookCreative')->disableOriginalConstructor()
                                    ->getMock();

        $mockBudget = new Budget("invalid", "impression", "lifetime");
        $mockUnmanagedFbBlob = new UnmanagedFacebookBlob();
        $mockUnmanagedFbBlob->setAdAccountId(1123);
        $mockUnmanagedFbBlob->setPageId([1, 2, 3]);
        $mockUnmanagedFbBlob->setAccessToken(["helloworld"]);
        $mockUnmanagedFbBlob->setStatus('');
        $mockUnmanagedFbBlob->setCreatives([$mockCreative]);
        $mockUnmanagedFbBlob->setAdSets([$mockAdSet]);
        $mockUnmanagedFbBlob->setBudget($mockBudget);
        $mockScenarioBlob->expects($this->once())
                         ->method('getBlob')
                         ->will($this->returnValue($mockUnmanagedFbBlob));

        $results = $this->sut->isValidUpdateBlob($mockScenarioBlob);
        $this->assertEquals(
            '[adAccountId] Integer value found, but a string is required. '
            . '[pageId] Array value found, but a string or a number is required. '
            . '[accessToken] Array value found, but a string is required. '
            . '[budget.amount] String value found, but a number is required. '
            . '[budget.budget_type] Does not have a value in the enumeration ["daily"]. '
            . '[budget.type] Does not have a value in the enumeration ["dollar"]. '
            . '[budget] Failed to match all schemas. [budget] Object value found, but a null is required. '
            . '[budget] Failed to match exactly one schema. [adSets[0]] NULL value found, but an object is required. '
            . '[adSets] Array value found, but a null is required. [adSets] Failed to match exactly one schema. '
            . '[creatives[0]] NULL value found, but an object is required. '
            . '[creatives] Array value found, but a null is required. [creatives] Failed to match exactly one schema. '
            . '[status] Does not have a value in the enumeration ["active","inactive"]. '
            . '[status] String value found, but a null is required. [status] Failed to match exactly one schema. '
            . '[] Failed to match all schemas.',
            $results->getMessage()
        );

        $this->assertEquals(false, $results->getResult());
    }
}

