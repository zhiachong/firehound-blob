<?php

namespace PaperG\Common\Test\Dcm;


use PaperG\FirehoundBlob\Dcm\DcmCreativeAsset;
use PaperG\FirehoundBlob\Dcm\UnmanagedDcmBlob;
use PaperG\FirehoundBlob\Facebook\UnmanagedFacebookBlob;

class UnmanagedDcmBlobTest extends \FirehoundBlobTestCase
{
    /**
     *
     */
    public function testToFromArray()
    {
        $sut = new UnmanagedDcmBlob();
        $mockAdTag = "mock ad tag";
        $mockCreativeAssetArray = [
            DcmCreativeAsset::AD_TAG => $mockAdTag
        ];
        $testArray = [
            UnmanagedDcmBlob::CREATIVE_ASSETS => [
                $mockCreativeAssetArray
            ]
        ];
        $mockCallbackUrl = 'mock callback url';
        $mockAdvId = 'mock adv id';
        $mockPublicationId = 'mock pub id';
        $mockHeaders = ['mock headers'];
        $testArray[UnmanagedDcmBlob::STATUS_CALLBACK_URL] = $mockCallbackUrl;
        $testArray[UnmanagedDcmBlob::GOOGLE_ADVERTISER_ID] = $mockAdvId;
        $testArray[UnmanagedDcmBlob::PUBLICATION_ID] = $mockPublicationId;
        $testArray[UnmanagedDcmBlob::STATUS_CALLBACK_HEADERS] = $mockHeaders;
        $sut->fromArray($testArray);
        $assets = $sut->getCreativeAssets();
        $asset = $assets[0];
        $this->assertEquals($mockAdTag, $asset->getAdTag());
        $this->assertEquals($mockCallbackUrl, $sut->getStatusCallbackUrl());
        $this->assertEquals($mockAdvId, $sut->getAdvertiserId());
        $this->assertEquals($mockPublicationId, $sut->getPublicationId());
        $this->assertEquals($mockHeaders, $sut->getStatusCallbackHeaders());
        $array = $sut->toArray();

        $this->assertEquals(
            $testArray[UnmanagedDcmBlob::CREATIVE_ASSETS][0][DcmCreativeAsset::AD_TAG],
            $array[UnmanagedDcmBlob::CREATIVE_ASSETS][0][DcmCreativeAsset::AD_TAG]
        );
        $this->assertEquals($mockCallbackUrl, $array[UnmanagedDcmBlob::STATUS_CALLBACK_URL]);
        $this->assertEquals($mockAdvId, $array[UnmanagedDcmBlob::GOOGLE_ADVERTISER_ID]);
        $this->assertEquals($mockPublicationId, $array[UnmanagedDcmBlob::PUBLICATION_ID]);
        $this->assertEquals($mockHeaders, $array[UnmanagedDcmBlob::STATUS_CALLBACK_HEADERS]);
    }
} 
