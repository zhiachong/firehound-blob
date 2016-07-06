<?php

namespace PaperG\Common\Test\Facebook\Targeting;


use PaperG\FirehoundBlob\Facebook\Targeting\FacebookDemographicTargeting;

class FacebookDemographicTargetingTest extends \FirehoundBlobTestCase
{
    /**
     * @var FacebookDemographicTargeting
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new FacebookDemographicTargeting();
    }

    public function testToFromArray()
    {
        $mockGender = "male";
        $this->sut->setGender($mockGender);

        $array = $this->sut->toArray();
        $new = new FacebookDemographicTargeting($array);
        $this->assertEquals($this->sut, $new);

        $this->assertEquals($mockGender, $new->getGender());
    }
} 
