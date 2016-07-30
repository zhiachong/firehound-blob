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

    public function test_isValid_WithValidType_ReturnsTrue()
    {
        $dummyType = 'link';
        $this->sut->setType($dummyType);
        $this->sut->setObjects([1,2,3,4]);
        $this->assertEquals(true, $this->sut->isValid());
    }

    public function test_isValid_WithInvalidType_ReturnsFalse()
    {
        $dummyType = 'some_link_no_one_knows';
        $this->sut->setType($dummyType);
        $this->sut->setObjects([1,2,3,4]);
        $this->assertEquals(false, $this->sut->isValid());
    }
} 
