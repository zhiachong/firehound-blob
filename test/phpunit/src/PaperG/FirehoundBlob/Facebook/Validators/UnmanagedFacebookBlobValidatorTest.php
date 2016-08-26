<?php

namespace PaperG\Common\Test\Facebook\Validators;

use PaperG\FirehoundBlob\CampaignData\Budget;
use PaperG\FirehoundBlob\Facebook\FacebookAdSet;
use PaperG\FirehoundBlob\Facebook\FacebookCreative;
use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;
use PaperG\FirehoundBlob\Facebook\Targeting\FacebookGeographicTargeting;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;
use PaperG\FirehoundBlob\Facebook\Validators\UnmanagedFacebookBlobValidator;

class UnmanagedFacebookBlobValidatorTest extends \FirehoundBlobTestCase
{
    /**
     * @var UnmanagedFacebookBlobValidator
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new UnmanagedFacebookBlobValidator();
    }

    public function testValidateUpdate()
    {
        $mockAdAccountId = 'mock ad account id';
        $mockPageId = 'mock page id';
        $mockAccessToken = 'mock access token';
        $geo = new FacebookGeographicTargeting();
        $geo->setCityAction('include');
        $geo->setCityIds([12,32]);
        $blob = new UnmanagedFacebookBlob();
        $blob->setGeographicTargeting($geo);
        $blob->setAdAccountId($mockAdAccountId);
        $blob->setPageId($mockPageId);
        $blob->setAccessToken($mockAccessToken);
        $blob->setStatus("active");

        $result = $this->sut->validateUpdate($blob);
        $this->assertTrue($result->getResult());
        $this->assertEmpty($result->getMessage());
    }

    public function testValidateUpdateBadBudget()
    {
        $mockAdAccountId = 'mock ad account id';
        $mockPageId = 'mock page id';
        $mockAccessToken = 'mock access token';
        $geo = new FacebookGeographicTargeting();
        $geo->setCityAction('include');
        $geo->setCityIds([12,32]);
        $blob = new UnmanagedFacebookBlob();
        $blob->setGeographicTargeting($geo);
        $blob->setAdAccountId($mockAdAccountId);
        $blob->setPageId($mockPageId);
        $blob->setAccessToken($mockAccessToken);
        $blob->setStatus("active");
        $budget = new Budget(1, "invalid");
        $blob->setBudget($budget);
        $result = $this->sut->validateUpdate($blob);
        $this->assertFalse($result->getResult());
        $expected = "[budget.type] Does not have a value in the enumeration [\"impression\",\"dollar\"]. "
            . "[budget.budget_type] Does not have a value in the enumeration [\"daily\"]. "
            . "[budget.type] Does not have a value in the enumeration [\"dollar\"]. "
            . "[budget] Failed to match all schemas. [budget] Object value found, but a null is required. "
            . "[budget] Failed to match exactly one schema. [] Failed to match all schemas.";
        $this->assertEquals($expected, $result->getMessage());
    }

    public function testValidateCreate()
    {
        $adSet = new FacebookAdSet();
        $creative = new FacebookCreative();
        $creativeData = new FacebookCreativeData();
        $creativeData->setMediaUrl("blah");
        $creativeData->setName('name');
        $creative->setPrimary($creativeData);
        $creative->setType('link');
        $blob = new UnmanagedFacebookBlob();
        $blob->setStatus("active");
        $blob->setAdSets([$adSet]);
        $blob->setCreatives([$creative]);
        $blob->setAdAccountId('ad account id');
        $blob->setPageId(1234);
        $blob->setAccessToken('access token');

        $result = $this->sut->validateCreate($blob);
        $this->assertEmpty($result->getMessage());
        $this->assertTrue($result->getResult());
    }

    public function testValidateCreateReturnsFalse()
    {
        $adSet = new FacebookAdSet();
        $blob = new UnmanagedFacebookBlob();
        $blob->setStatus("blah");
        $blob->setAdSets([$adSet]);
        $blob->setAdAccountId('ad account id');
        $blob->setPageId(1234);

        $result = $this->sut->validateCreate($blob);
        $this->assertFalse($result->getResult());
        $this->assertEquals(
            '[accessToken] NULL value found, but a string is required. '
            . '[status] Does not have a value in the enumeration ["active","inactive"]. '
            . '[creatives] NULL value found, but an array is required. '
            . '[] Failed to match all schemas.', $result->getMessage()
        );
    }
}
