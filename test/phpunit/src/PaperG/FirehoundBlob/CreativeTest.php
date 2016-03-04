<?php

use PaperG\FirehoundBlob\CampaignData\Creative;

class CreativeTest extends PHPUnit_Framework_TestCase
{
    public function test_setGetLandingPage_shouldReturnLandingPage()
    {
        $mockLanding = "mock";
        $creative = new Creative();
        $creative->setLandingPage($mockLanding);

        $this->assertEquals($mockLanding, $creative->getLandingPage());
    }

    public function test_setGetCaption_shouldReturnCaption()
    {
        $mockLanding = "mock";
        $creative = new Creative();
        $creative->setCaption($mockLanding);

        $this->assertEquals($mockLanding, $creative->getCaption());
    }

    public function test_toFromArray()
    {
        $mockUrl = "mock";
        $mockMessage = "mockMessage";
        $mockCall = "mockCall";
        $mockCaption = "mockCaption";
        $mockLandingPage = "mockLandingPage";
        $creative = new Creative();
        $creative->setMediaUrl($mockUrl);
        $creative->setMessage($mockMessage);
        $creative->setCallToAction($mockCall);
        $creative->setCaption($mockCaption);
        $creative->setLandingPage($mockLandingPage);
        $array = $creative->toAssociativeArray();
        $this->assertEquals($mockCall, $array[Creative::CALL_TO_ACTION]);
        $creative = Creative::fromAssociativeArray($array);
        $this->assertEquals($mockUrl, $creative->getMediaUrl());
        $this->assertEquals($mockMessage, $creative->getMessage());
        $this->assertEquals($mockCall, $creative->getCallToAction());
        $this->assertEquals($mockCaption, $creative->getCaption());
        $this->assertEquals($mockLandingPage, $creative->getLandingPage());
    }

    public function test_isValidWithMessageMedia_shouldReturnTrue()
    {
        $mockMedia = "mockM";
        $mockMessage = "mockMessage";
        $creative = new Creative();
        $creative->setMediaUrl($mockMedia);
        $this->assertFalse($creative->isValid());
        $creative->setMessage($mockMessage);
        $this->assertTrue($creative->isValid());
        $this->assertEquals($mockMedia, $creative->getMediaUrl());
        $this->assertEquals($mockMessage, $creative->getMessage());
    }

    public function test_getSetName_shouldReturnName()
    {
        $mockName = "mock name";
        $creative = new Creative();
        $creative->setName($mockName);
        $this->assertEquals($mockName, $creative->getName());
    }

    public function test_getSetDescription_shouldReturnDescription()
    {
        $mockDesc = "mock description, pretty short!!";
        $creative = new Creative();
        $creative->setDescription($mockDesc);
        $this->assertEquals($mockDesc, $creative->getDescription());
    }
}
