<?php

use PaperG\FirehoundBlob\CampaignData\Context;

class ContextTest extends PHPUnit_Framework_TestCase
{
    public function test_fromAssociativeArray_setsFacebookCorrectly()
    {
        $mockAccountId = 1234;
        $mockPageId = 321;
        $mockArray = array(
            Context::FACEBOOK_CONTEXT => array(
                Context\FacebookContext::AD_ACCOUNT_ID => $mockAccountId,
                Context\FacebookContext::PAGE_ID => $mockPageId
            )
        );

        $context = Context::fromAssociativeArray($mockArray);
        $facebookContext = $context->getFacebookContext();
        $this->assertEquals($mockPageId, $facebookContext->getPageId());
        $this->assertEquals($mockAccountId, $facebookContext->getAdAccountId());
    }

    public function test_getSetValueByKey_returnsCorrectValue()
    {
        $mockKey = "mockkey";
        $mockValue = "mockValue";
        $context = new Context();
        $context->setValueByKey($mockKey, $mockValue);
        $this->assertEquals($mockValue, $context->getValueByKey($mockKey));
    }
}
