<?php

namespace PaperG\Common\Test\Facebook\Creative;


use PaperG\FirehoundBlob\Facebook\Creative\FacebookCarouselCreativeData;
use PaperG\FirehoundBlob\Facebook\FacebookCreativeData;

class FacebookCarouselCreativeDataTest extends \FirehoundBlobTestCase
{

    public function testToFromArray()
    {
        $mockCall = "mock call";
        $array = [
            FacebookCreativeData::CALL_TO_ACTION => $mockCall,
            FacebookCarouselCreativeData::MULTI_SHARE_END_CARD => true
        ];
        $sut = new FacebookCarouselCreativeData($array);
        $this->assertEquals($mockCall, $sut->getCallToAction());
        $this->assertTrue($sut->hasUseEndCard());

        $newArray = $sut->toArray();
        $this->assertEquals($mockCall, $newArray[FacebookCreativeData::CALL_TO_ACTION]);
        $this->assertTrue($newArray[FacebookCarouselCreativeData::MULTI_SHARE_END_CARD]);
    }
} 
