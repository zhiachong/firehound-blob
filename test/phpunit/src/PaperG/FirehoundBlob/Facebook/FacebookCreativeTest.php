<?php

namespace PaperG\Common\Test\Facebook;


use PaperG\FirehoundBlob\Facebook\FacebookCreative;
use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;

class FacebookCreativeTest extends \FirehoundBlobTestCase
{
    /**
     * @var FacebookCreative
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new FacebookCreative();
    }

    public function testToFromArray()
    {
        $mockType = "mock type";
        $mockName = "mockName";
        $mockCreativeData = new FacebookCreativeData();
        $mockCreativeData->setName($mockName);

        $this->sut->setType($mockType);
        $this->sut->setObjects([$mockCreativeData]);

        $array = $this->sut->toArray();
        $newObject = new FacebookCreative($array);
        $this->assertEquals($this->sut, $newObject);
    }
} 
