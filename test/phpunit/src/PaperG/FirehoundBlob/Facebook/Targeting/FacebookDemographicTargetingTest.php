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

    public function test_isValid_AgeWithinRange_ReturnsTrue()
    {
        $mockMinAge = 20;
        $mockMaxAge = 50;

        $this->sut->setMinAge($mockMinAge);
        $this->sut->setMaxAge($mockMaxAge);

        $actual = $this->sut->isValid();
        $this->assertEquals(true, $actual);
    }

    public function test_isValid_OverMaxAge_ReturnsFalse()
    {
        $mockMinAge = 20;
        $mockMaxAge = 75;

        $this->sut->setMinAge($mockMinAge);
        $this->sut->setMaxAge($mockMaxAge);

        $actual = $this->sut->isValid();
        $this->assertEquals(false, $actual);
    }

    public function test_isValid_UnderMinAge_ReturnsFalse()
    {
        $mockMinAge = 15;
        $mockMaxAge = 65;

        $this->sut->setMinAge($mockMinAge);
        $this->sut->setMaxAge($mockMaxAge);

        $actual = $this->sut->isValid();
        $this->assertEquals(false, $actual);
    }
} 
