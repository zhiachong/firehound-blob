<?php

use PaperG\FirehoundBlob\CampaignData\Targeting;

class TargetingTest extends FirehoundBlobTestCase
{
    public function test_getSetGeographic_shouldReturnTheCorrectValues()
    {
        $mockGeotargeting = $this->buildMockGeotargeting();
        $targeting = new Targeting(null);
        $targeting->setGeographic($mockGeotargeting);
        $this->assertEquals($mockGeotargeting, $targeting->getGeographic());
    }

    public function test_toFromAssociativeArray_targetingOnly()
    {
        $mockReturnArray = array("hi" => "bye");
        $mockGeotargeting = $this->buildMockGeotargeting();
        $mockGeotargeting->expects($this->once())
            ->method('toAssociativeArray')
            ->will($this->returnValue($mockReturnArray));
        $targeting = new Targeting($mockGeotargeting);

        $array = $targeting->toAssociativeArray();
        $this->assertEquals($mockReturnArray, $array[Targeting::GEOGRAPHIC]);
    }

    public function getSetAudienceTargeting_shouldReturnCorrectValues()
    {
        $mockAudienceTargeting =$this->buildMock('\PaperG\FirehoundBlob\CampaignData\Targeting\AudienceTargeting');

        $mockGeotargeting = $this->buildMockGeotargeting();
        $targeting = new Targeting($mockGeotargeting);
        $null = $targeting->getAudienceTargeting();
        $this->assertNull($null);
        $targeting->setAudienceTargeting($mockAudienceTargeting);
        $this->assertEquals($mockAudienceTargeting, $targeting->getAudienceTargeting());
    }

    private function buildMockGeotargeting()
    {
        return $this->buildMock('\PaperG\FirehoundBlob\CampaignData\CampaignGeoTargetingData');
    }
}
