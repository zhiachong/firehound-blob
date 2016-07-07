<?php

namespace PaperG\Common\Test\Facebook\Targeting;


use PaperG\FirehoundBlob\Facebook\Targeting\FacebookGeographicTargeting;

class FacebookGeographicTargetingTest extends \FirehoundBlobTestCase
{
    /**
     * @var FacebookGeographicTargeting
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new FacebookGeographicTargeting();
    }

    public function testToFromArray()
    {
        $mockCityAction = "city action";
        $this->sut->setCityAction($mockCityAction);

        $array = $this->sut->toArray();
        $new = new FacebookGeographicTargeting($array);

        $this->assertEquals($this->sut, $new);
        $this->assertEquals($mockCityAction, $new->getCityAction());
    }
} 
