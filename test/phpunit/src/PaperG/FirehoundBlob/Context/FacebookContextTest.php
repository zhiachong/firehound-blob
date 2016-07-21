<?php
use PaperG\FirehoundBlob\CampaignData\Context\FacebookContext;

class FacebookContextTest extends FirehoundBlobTestCase
{
    public function test_getSetPageId_shouldReturnCorrectValues()
    {
        $mockPageId = "mock page id";
        $facebookContext = new FacebookContext();
        $facebookContext->setPageId($mockPageId);
        $this->assertEquals($mockPageId, $facebookContext->getPageId());
    }

    public function test_getSetAdAccountId_shouldReturnCorrectValues()
    {
        $mockAdAccountID = "mock ad account id";
        $facebookContext = new FacebookContext();
        $facebookContext->setAdAccountId($mockAdAccountID);
        $this->assertEquals($mockAdAccountID, $facebookContext->getAdAccountId());
    }

    public function test_getSetAdSets_shouldReturnCorrectValues()
    {
        $mockAdSet = $this->buildMock('\PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\FacebookAdSet');
        $mockAdSets = [$mockAdSet];
        $facebookContext = new FacebookContext();
        $facebookContext->setAdSets($mockAdSets);

        $this->assertEquals($mockAdSets, $facebookContext->getAdSets());
    }

    public function test_toFromAssociativeArray_returnsCorrectValues()
    {
        $mockPageID = "mockPageId";
        $mockAdAccountID = "mockAdAccountId";
        $mockAdSetArray = array("adSetId" => "bar");
        $mockAdSet = $this->buildMock('\PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\FacebookAdSet');
        $mockAdSet->expects($this->once())
            ->method('toAssociativeArray')
            ->will($this->returnValue($mockAdSetArray));
        $mockAdSets = [$mockAdSet];
        $facebookContext = new FacebookContext();
        $facebookContext->setAdAccountId($mockAdAccountID);
        $facebookContext->setPageId($mockPageID);
        $facebookContext->setAdSets($mockAdSets);
        $expectedArray = array(
            FacebookContext::PAGE_ID => $mockPageID,
            FacebookContext::AD_ACCOUNT_ID => $mockAdAccountID,
            FacebookContext::AD_SETS => array(
                $mockAdSetArray
            ),
            FacebookContext::ACCESS_TOKEN => null
        );
        $associativeArray = $facebookContext->toAssociativeArray();
        $this->assertEquals($expectedArray, $associativeArray);
        $facebookContext->setAdSets(null);
        $facebookContext->setPageId(null);
        $facebookContext->setAdAccountId(null);
        $facebookContext->fromAssociativeArray($associativeArray);
        $this->assertEquals($mockPageID, $facebookContext->getPageId());
        $this->assertEquals($mockAdAccountID, $facebookContext->getAdAccountId());
        $adSet = $facebookContext->getAdSets()[0];
        $this->assertEquals("bar", $adSet->getAdSetId());
    }
}
