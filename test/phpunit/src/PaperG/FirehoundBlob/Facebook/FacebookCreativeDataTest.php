<?php

namespace PaperG\Common\Test\Facebook;


use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;

class FacebookCreativeDataTest extends \FirehoundBlobTestCase
{
    /**
     * @var FacebookCreativeData
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new FacebookCreativeData();
    }

    public function testToFromArray() {
        $mockMediaUrl = "mockMediaUrl";
        $mockCall = "mock call";
        $mockMessage = "mockMesage";
        $mockCaption = "mock caption";
        $mockLandingPage = "langing";
        $mockName = "name";
        $mockDescription = "mockDesc";
        $mockVariationId = "mock var uuid";

        $this->sut->setMediaUrl($mockMediaUrl);
        $this->sut->setCallToAction($mockCall);
        $this->sut->setMessage($mockMessage);
        $this->sut->setCaption($mockCaption);
        $this->sut->setLandingPage($mockLandingPage);
        $this->sut->setName($mockName);
        $this->sut->setDescription($mockDescription);
        $this->sut->setVariationId($mockVariationId);

        $arr = $this->sut->toArray();
        $new = new FacebookCreativeData($arr);

        $this->assertEquals($this->sut, $new);
    }
} 
