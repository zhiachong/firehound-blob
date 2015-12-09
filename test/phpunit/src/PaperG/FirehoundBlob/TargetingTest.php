<?php

use PaperG\Common\CampaignData\Targeting;

class TargetingTest extends \PHPUnit_Framework_TestCase
{
    public function test_getSetGeographic_shouldReturnTheCorrectValues()
    {
        $mockGeotargeting = $this->getMockBuilder('\PaperG\Common\CampaignData\CampaignGeoTargetingData')
            ->disableOriginalConstructor()
            ->getMock();
        $targeting = new Targeting(null);
        $targeting->setGeographic($mockGeotargeting);
        $this->assertEquals($mockGeotargeting, $targeting->getGeographic());
    }

    public function test_toFromAssociativeArray()
    {
        $mockReturnArray = array("hi" => "bye");
        $mockGeotargeting = $this->getMockBuilder('\PaperG\Common\CampaignData\CampaignGeoTargetingData')
            ->disableOriginalConstructor()
            ->getMock();
        $mockGeotargeting->expects($this->once())
            ->method('toAssociativeArray')
            ->will($this->returnValue($mockReturnArray));
        $targeting = new Targeting($mockGeotargeting);

        $array = $targeting->toAssociativeArray();
        $this->assertEquals($mockReturnArray, $array[Targeting::GEOGRAPHIC]);
    }
}
