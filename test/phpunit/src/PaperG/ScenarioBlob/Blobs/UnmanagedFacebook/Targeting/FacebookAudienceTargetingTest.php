<?php

namespace PaperG\Common\Test\Facebook\Targeting;


use PaperG\ScenarioBlob\Blobs\UnmanagedFacebook\Targeting\FacebookAudienceTargeting;

class FacebookAudienceTargetingTest extends \FirehoundBlobTestCase
{
    /**
     * @var FacebookAudienceTargeting
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new FacebookAudienceTargeting();
    }

    public function testToFromArray()
    {
        $mockIds = ["mock ids"];
        $mockType = "mock type";
        $this->sut->setIds($mockIds);
        $this->sut->setType($mockType);

        $array = $this->sut->toArray();

        $test = new FacebookAudienceTargeting($array);
        $this->assertEquals($this->sut, $test);
    }
}
